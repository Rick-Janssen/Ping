<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    
    <style>
        body,
        h3,
        p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .container {
            background-color: #0259CE;
            max-width: 600px;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .content {
            height: 200px;
            padding: 20px;
            text-align: center;
            color: #333;
            background-color: #2D333F;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .button {
            display: inline-block;
            width: 200px;
            height: 40px;
            text-decoration: none;
            background-color: #4CAF50;
            border-radius: 5px;
            color: white;
            line-height: 40px;
            text-align: center;
            margin-top: 100px;
        }

        .text {
            color: white;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>Password Reset</h3>
        </div>
        <div class="content">
            <p>{{ $data['body'] }}</p>
            <p class="text"></p>
            <a class="button" href="http://ping.test/resetpassword">Reset Your Password</a>
        </div>
    </div>
</body>

</html>
