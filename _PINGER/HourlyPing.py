import mysql.connector
import os
from dotenv import load_dotenv
from multiprocessing import Process
from datetime import datetime, timedelta

load_dotenv()

mydb = mysql.connector.connect(
    host=os.getenv("DB_HOST"),
    user=os.getenv("DB_USERNAME"),
    password=os.getenv("DB_PASSWORD"),
    database=os.getenv("DB_DATABASE"),
)

mycursor = mydb.cursor()

mycursor.execute("SELECT DISTINCT host_name FROM pings")
host_names = mycursor.fetchall()

for host_name in host_names:
    mycursor.execute(
        "SELECT MIN(ms) as min_ping, MAX(ms) as max_ping, ROUND(AVG(ms), 2) as avg_ping FROM pings WHERE host_name = %s AND created_at >= (NOW() - INTERVAL 1 HOUR) AND ms >= 0",
        (host_name[0],),
    )
    aggregated_data = mycursor.fetchone()

    min_ping, max_ping, avg_ping = aggregated_data
    min_ping = min_ping or 0
    max_ping = max_ping or 0
    avg_ping = avg_ping or 0

    current_time = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    insert_query = (
        "INSERT INTO `hourly_average` (`created_at`, `updated_at`, `host_name`, `minMS`, `maxMS`, `avg`) "
        "VALUES (%s, %s, %s, %s, %s, %s)"
    )
    insert_values = (
        current_time,
        current_time,
        host_name[0],
        min_ping,
        max_ping,
        avg_ping,
    )

    mycursor.execute(insert_query, insert_values)
    mydb.commit()

    # Delete pings from the last hour
    delete_query = "DELETE FROM pings WHERE host_name = %s AND created_at >= (NOW() - INTERVAL 1 HOUR)"
    mycursor.execute(delete_query, (host_name[0],))
    mydb.commit()

mycursor.close()
mydb.close()
