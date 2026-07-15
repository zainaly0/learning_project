<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../helpers/functions.php";


if($_SERVER['REQUEST_METHOD'] == "POST"){


}













?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <style>
        body{
            margin: 0;
            padding: 0;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }
        .container{
            min-height: 100vh;
            display:flex;
            justify-content: center;
            align-items: center;
        }

        h2{
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .main{
            width: 380px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,.1);
        }

        .input_group{
            margin: 2px;
        }
        label{
            display: block;
            margin-bottom: 6px;
        }

        input{
            height: 42px;
            width: 100%;
            padding: 0 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        input[type="submit"]{
            width: 100%;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        input[type="submit"]:hover{
            background: #0056b3;
        }


    </style>
</head>
<body>

<div class="container">
    <div class="main">
        <form action="" method="post">
            <h2>User Login</h2>
            <div class="input_group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Enter Email">
                <span style="color: red;">
                    <?php echo ""; ?>
                </span>
            </div>
            <div class="input_group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Enter password">
                <span style="color:red;">
                    <?php echo ""; ?>
                </span>
            </div>
            

            <input type="submit" name="Submit" value="Submit">

        </form>
    </div>
</div>

</body>
</html>