<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../helpers/functions.php";
require_once __DIR__ . "/../config/session.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email'] ?? "");
    $password = trim($_POST['password'] ?? "");

    $errors = [];

    if (empty($email)) {
        $errors['email'] = "Email is empty";
    }
    if (empty($password)) {
        $errors['password'] = "Password is empty";
    }

    if (!empty($errors)) {

    } elseif (empty($errors)) {

        // $db_query = "select * from users where email='$email'";
        // $result = mysqli_query($conn, $db_query);    //sql injection problem

        $stmt = mysqli_prepare($conn, "SELECT * from users WHERE email=?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows == 0) {
            $errors['Email'] = "creadential is not matched";
            redirect("/auth/login.php");
            exit;
        }
        $user = mysqli_fetch_assoc($result);

        if ($user['status'] == 0) {
            $errors['status'] = "Your account is disabled.";
            redirect("/auth/login.php");
            exit;
        }

        if ($user['email_verified_at'] == null) {
            $errors['email_verified_at'] = "Email not varified";
            redirect('/auth/login.php');
            exit;
        }
        $passmatch = password_verify($password, $user['password']);
        if ($passmatch) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            if (isset($_POST['remember'])) {
                $user_id = $_SESSION['user_id'];
                $plainToken = bin2hex(random_bytes(32));
                $hashedtoken = hash('sha256', $plainToken);
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $user_agent = $_SERVER['HTTP_USER_AGENT'];

                // Device name
                $device_name = "Unknown Device";
                if (strpos($user_agent, 'Windows') !== false) {
                    $device_name = "Windows PC";
                } elseif (strpos($user_agent, 'Macintosh') !== false) {
                    $device_name = "Mac";
                } elseif (strpos($user_agent, 'Android') !== false) {
                    $device_name = "Android";
                } elseif (strpos($user_agent, 'iPhone') !== false) {
                    $device_name = 'iPhone';
                }

                // device type 
                $device_type = "";
                if (preg_match("/Mobile|Android|iPhone/i", $user_agent)) {
                    $device_type = "Mobile";
                } elseif (preg_match("/iPad|Tablet/i", $user_agent)) {
                    $device_type = "Tablet";
                } else {
                    $device_type = "Desktop";
                }

                $expires_at = date('Y-m-d H:i:s', strtotime("+30 days"));
                $last_used_at = date('Y-m-d H:i:s');

                $sql = "insert into remember_tokens(user_id, token, device_name, device_type, ip_address, user_agent, expires_at, last_used_at) values('$user_id', '$hashedtoken', '$device_name', '$device_type', '$ip_address', '$user_agent', '$expires_at', '$last_used_at')";

                if (mysqli_query($conn, $sql)) {
                    // setcookie(name,value,expires,path,domain,secure,httponly);
                    setcookie('remember_token', $plainToken, time() + (60 * 60 * 24 * 30), "/", "", false, true);
                }


            }
            redirect("/dashboard/dashboard.php");
            exit;
        } else {
            $errors['credential'] = "wrong credential";
        }

    }

}

if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];
    $hashtokencheck = hash('sha256', $token);

    $stmt1 = $conn->prepare("select * from remember_tokens where token=?");
    $stmt1->bind_param("s", $hashtokencheck);
    $stmt1->execute();

    $result = $stmt1->get_result();

    // echo "<pre>";
    // var_dump($result->num_rows > 0);
    // exit;


    if ($result->num_rows > 0) {
        $data = mysqli_fetch_object($result);
        $user_id = $data->user_id;
        
        $stmt2 = $conn->prepare("select * from users where id=?");
        $stmt2->bind_param("i", $user_id);
        $stmt2->execute();
        
        $result2 = $stmt2->get_result();
        if ($result2->num_rows > 0) {
            session_regenerate_id();
            $userdata = mysqli_fetch_object($result2);
            $_SESSION['user_id'] = $userdata->id;
            $_SESSION['name'] = $userdata->name;
            $_SESSION['email'] = $userdata->email;

            redirect("/dashboard/dashboard.php");
        }

    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
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
            margin-bottom: 6px;
        }

        input {
            height: 42px;
            width: 100%;
            padding: 0 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
        }

        input[type="submit"] {
            width: 100%;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 15px 0 20px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-size: 14px;
            color: #555;
        }

        .remember input[type="checkbox"] {
            width: 16px;
            height: 16px;
            margin: 0;
            accent-color: #007bff;
        }

        .options a {
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        .options a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="main">
            <form action="" method="post">
                <h2>User Login</h2>

                <p><?php echo isset($errors['credential']) ? $errors['credential'] : ""; ?></p>
                <div class="input_group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="Enter Email"
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ""; ?>">
                    <span style="color: red;">
                        <?php echo isset($errors['email']) ? $errors['email'] : ""; ?>
                    </span>
                </div>
                <div class="input_group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" placeholder="Enter password">
                    <span style="color:red;">
                        <?php echo isset($errors['password']) ? $errors['password'] : ""; ?>
                    </span>
                </div>
                <div class="input_group options">
                    <label class="remember">
                        <input type="checkbox" name="remember" value="1">
                        Remember Me
                    </label>
                    <a href="forget-password.php">Forget Password? </a>
                </div>


                <input type="submit" name="Submit" value="Submit">

            </form>
        </div>
    </div>

</body>

</html>