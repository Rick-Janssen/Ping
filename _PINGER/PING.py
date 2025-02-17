import mysql.connector
import os
import re
import subprocess
from dotenv import load_dotenv

load_dotenv()

mydb = mysql.connector.connect(
    host=os.getenv("DB_HOST"),
    user=os.getenv("DB_USERNAME"),
    password=os.getenv("DB_PASSWORD"),
    database=os.getenv("DB_DATABASE"),
)


def connect_to_database():
    try:
        return mydb.cursor(buffered=True), mydb
    except mysql.connector.Error as err:
        print(f"Error: {err}")
        return None, None


def close_database_connection(cursor, mydb):
    cursor.close()
    mydb.close()


def execute_query(cursor, query, values=None):
    try:
        cursor.execute(query, values)
        mydb.commit()
    except mysql.connector.Error as err:
        print(f"Error: {err}")


def check_and_insert_error(
    cursor, host_id, host_name, error_message, error_type, result=None
):
    query = "SELECT COUNT(*) FROM errors WHERE host_id = %s AND created_at > (NOW() - INTERVAL 1 HOUR)"
    cursor.execute(query, (host_id,))
    existing_errors_count = cursor.fetchone()[0]

    if existing_errors_count == 0:
        query = "INSERT INTO errors (host_id, host_name, error, type, created_at, ms) VALUES (%s, %s, %s, %s, current_timestamp(), %s)"
        values = (host_id, host_name, error_message, error_type, result)
        execute_query(cursor, query, values)
        print(f"Error inserted for host: {host_name}")
    else:
        print(f"An error already exists for host: {host_name}")


def main():
    mycursor, mydb = connect_to_database()

    if mycursor and mydb:
        mycursor.execute("SELECT id, name, ip FROM hosts")
        records = mycursor.fetchall()

        mycursor.execute("SELECT * FROM settings LIMIT 1")
        settings = mycursor.fetchone()

        consecutive_positive_pings = {}
        max_consecutive_errors = settings[2]

        if records:
            for row in records:
                host_id = row[0]

                # Check if the host has an active error
                active_error_query = "SELECT id FROM errors WHERE host_id = %s"
                mycursor.execute(active_error_query, (host_id,))
                active_error = mycursor.fetchone()

                if active_error:
                    # Check the three latest pings until there are three consecutive positive pings
                    query = "SELECT ms FROM pings WHERE host_id = %s ORDER BY created_at DESC LIMIT 3"
                    mycursor.execute(query, (host_id,))
                    latest_pings = [
                        ping[0] for ping in mycursor.fetchall() if ping[0] is not None
                    ]

                    if len(latest_pings) == 3 and all(
                        ping > 0 for ping in latest_pings
                    ):
                        # Delete the active error connected to the host
                        move_to_past_errors_query = (
                            "INSERT INTO past_errors SELECT * FROM errors WHERE id = %s"
                        )

                        mycursor.execute(move_to_past_errors_query, (active_error[0],))
                        mydb.commit()

                        delete_error_query = "DELETE FROM errors WHERE id = %s"
                        mycursor.execute(delete_error_query, (active_error[0],))
                        mydb.commit()
                        print(f"Error resolved for host: {row[1]}")
                    else:
                        print(f"Host {row[1]} still has an active error")

                try:
                    ping_process = subprocess.Popen(["ping", "-c", "1", "-w", "1000", row[2]], stdout=subprocess.PIPE)

                    tail_process = subprocess.Popen(["tail", "-1"], stdin=ping_process.stdout, stdout=subprocess.PIPE)

                    awk_process = subprocess.Popen(["awk", "{print $4}"], stdin=tail_process.stdout, stdout=subprocess.PIPE)

                    cut_process = subprocess.Popen(["cut", "-d", "/", "-f", "2"], stdin=awk_process.stdout, stdout=subprocess.PIPE) 



                    output, _ = cut_process.communicate()

                    ping_response = output.decode().strip()
                    if "Request timed out." in ping_process.stdout:
                        query = "SELECT ms FROM pings WHERE host_id = %s AND ms = -1 ORDER BY created_at DESC LIMIT %s"
                        values = (host_id, max_consecutive_errors)
                        mycursor.execute(query, values)
                        latest_three_pings = mycursor.fetchall()

                        print(latest_three_pings)

                        print("No Answer")
                        result = -1
                        error_message = "Timed out"

                        if len(latest_three_pings) >= max_consecutive_errors:
                            check_and_insert_error(
                                mycursor,
                                host_id,
                                row[1],
                                error_message,
                                "Error",
                                result,
                            )
                        consecutive_positive_pings[host_id] = 0
                    else:
                        consecutive_positive_pings[host_id] = (
                            consecutive_positive_pings.get(host_id, 0) + 1
                        )
                        ping_match = ping_response


                        if ping_match:
                            result = ping_match
                            print("Average: " + str(result) + " ms")
                            error_message = None
                        else:
                            print("No Average found in ping response")
                            result = -1
                            error_message = "No Average"

                except subprocess.TimeoutExpired:
                    print("Ping timed out")
                    result = -1
                    error_message = "Timed out"
                    if (
                        consecutive_positive_pings.get(host_id, 0)
                        >= max_consecutive_errors
                    ):
                        check_and_insert_error(
                            mycursor, host_id, row[1], error_message, "Error", result
                        )

                query = "INSERT INTO pings (host_id, host_name, ms, created_at) VALUES (%s, %s, %s, current_timestamp())"
                values = (host_id, row[1], result)
                execute_query(mycursor, query, values)

        else:
            print("No Hosts")

        close_database_connection(mycursor, mydb)


if __name__ == "__main__":
    main()
