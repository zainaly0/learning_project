<?php
    include "../config/config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $password = trim($_POST['password']);
        $status = trim($_POST['status']);
        
        // file handling
        $fileName = $_FILES['profile_image']['name'];
        $tempName = $_FILES['profile_image']['tmp_name'];

        $uploaddir = "uploads/";

        if(!is_dir($uploaddir)){
            mkdir($uploaddir, 0777, true);
        }

        $filesave = move_uploaded_file($tempName, $uploaddir.$fileName);
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

        $sql_query = "insert into users(name, email, phone, password, profile_image, status) VALUES('$name', '$email', '$phone', '$password', '$tempName', '$status')";
        $record_created = mysqli_query($conn, $sql_query);
 




    }


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .main {
            width: 380px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        }

        input {
            height: 40px;
            width: 24vw;
        }

        .input_group {
            margin: 2px;
        }

        label {
            display: block;
            margin-bottom: 6px;
        }

        input[type='file'] {
            padding: 8px;
            height: auto;
        }

        input,
        select {
            height: 42px;
            width: 100%;
            padding: 0 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;

        }


        input[type='submit'] {
            width: 100%;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: .3s;
        }

        input[type='submit']:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="main">
            <form action="" method="post" enctype="multipart/form-data">
                <h2>User Registration</h2>
                <div class="input_group">
                    <label for="name">Name</label>
                    <input id="name" type="text" name="name" placeholder="Enter Name">
                </div>

                <div class="input_group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="Enter Email">
                </div>


                <div class="input_group">
                    <label for="phone">Phone</label>
                    <input id="phone" type="number" name="phone" placeholder="Enter number" >
                </div>

                <div class="input_group">

                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Enter Password">


                </div>
                <div class="input_group">

                    <label for="profile_image">Profile Image</label>
                    <input id="profile_image" type="file" name="profile_image" placeholder="Add File">

                </div>
                <div class="input_group">

                    <label for="status">Choose Status</label>
                    <select id="status" name="status">
                        <option value="">Default</option>
                        <option value="1" selected>Active</option>
                        <option value="0" selected>Inactive</option>
                    </select>
                </div>

                <input type="submit" value="submit" name="Submit">

            </form>
        </div>
    </div>

</body>

</html>