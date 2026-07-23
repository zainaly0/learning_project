<?php
// $configfile = __DIR__ . "/../config/config.php";
// $functionsfile=  __DIR__ . "/../helpers/functions.php";
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../helpers/functions.php";

// if (file_exists($configfile)) {
//     require_once __DIR__ . "/../config/config.php";

// } else {
//     echo "config file not found";
// }

// if(file_exists($functionsfile)){
//     require_once __DIR__ . "/../helpers/functions.php";
// }else{
//     echo "functions file not found";
// }


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $password = trim($_POST['password'] ?? "");
    $status = trim($_POST['status'] ?? "");

    $errors = [];

    if (empty($name)) {
        $errors['name'] = "Name is required";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($phone)) {
        $errors['phone'] = "phone is empty";
    } elseif (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors['phone'] = "phone number must be 10 digits";
    }

    if (empty($password)) {
        $errors['password'] = "password is empty";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "password must be atleast 8 characters";
    }

    if ($status === "") {
        $errors['status'] = "Please select a status";
    }

    if (empty($errors)) {
        $checkuser = "SELECT * FROM users WHERE email='$email' or phone='$phone'";
        $result = mysqli_query($conn, $checkuser);
        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if ($user['email'] == $email) {
                $errors['email'] = "Email already exist";
            }

            if ($user['phone'] == $phone) {
                $errors['phone'] = "Phone number already exist";
            }
        }

        if ($_FILES['profile_image']['error'] != 0) {
            $errors['profile_image'] = "Please select an image";
        } else {
            $allowed = ['jpg', 'jpeg', 'png'];
            $extension = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowed)) {
                $errors['profile_image'] = "Only JPG, JPEG and PNG files are allowed";
            }

            if ($_FILES['profile_image']['size'] > 2 * 1024 * 1024) {
                $errors['profile_image'] = "image size must be less than 4 mb";
            }
        }

    }

    if (!empty($errors)) {

    } else {

        // file handling
        $fileName = time() . "_" . $_FILES['profile_image']['name'];
        $tempName = $_FILES['profile_image']['tmp_name'];


        $uploaddir = "../assets/uploads/";

        if (!is_dir($uploaddir)) {
            mkdir($uploaddir, 0777, true);
        }

        $filesave = move_uploaded_file($tempName, $uploaddir . $fileName);
        if ($filesave) {

            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

            $sql_query = "insert into users(name, email, phone, password, profile_image, status) VALUES('$name', '$email', '$phone', '$hashed_pass', '$fileName', '$status')";
            $record_created = mysqli_query($conn, $sql_query);

            if ($record_created) {
                redirect("auth/login.php");
            }
        } else {
            echo "image uploaded failed";
        }

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>


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
                    <input id="name" type="text" name="name" placeholder="Enter Name"
                        value="<?php echo isset($name) ? htmlspecialchars($name) : ""; ?>">
                    <span style="color:red">
                        <?php echo isset($errors['name']) ? $errors['name'] : ""; ?>
                    </span>
                </div>

                <div class="input_group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="Enter Email"
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ""; ?>">
                    <span style="color: red">
                        <?php echo isset($errors['email']) ? $errors['email'] : ""; ?>
                    </span>
                </div>


                <div class="input_group">
                    <label for="phone">Phone</label>
                    <input id="phone" type="number" name="phone" placeholder="Enter number"
                        value="<?php echo isset($phone) ? htmlspecialchars($phone) : ""; ?>">
                    <span style="color: red;">
                        <?php echo isset($errors['phone']) ? $errors['phone'] : ""; ?>
                    </span>
                </div>

                <div class="input_group">

                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Enter Password"
                        value="<?php echo isset($password) ? htmlspecialchars($password) : ""; ?>">
                    <span style="color: red;">
                        <?php echo isset($errors['password']) ? $errors['password'] : ""; ?>
                    </span>

                </div>
                <div class="input_group">

                    <label for="profile_image">Profile Image</label>
                    <input id="profile_image" type="file" name="profile_image" placeholder="Add File">
                    <span style="color: red;">
                        <?php echo isset($errors['profile_image']) ? $errors['profile_image'] : ""; ?>
                    </span>
                </div>
                <div class="input_group">

                    <label for="status">Choose Status</label>
                    <select id="status" name="status">
                        <option value="" selected>Default</option>
                        <option value="1" <?php echo (isset($status) && $status == 1) ? "selected" : ""; ?>>Active
                        </option>
                        <option value="0" <?php echo (isset($status) && $status == 0) ? "selected" : ""; ?>>Inactive
                        </option>
                    </select>

                    <span style="color: red;">
                        <?php echo isset($errors['status']) ? $errors['status'] : ""; ?>
                    </span>
                </div>

                <input type="submit" value="submit" name="Submit">

            </form>
        </div>
    </div>

</body>

</html>