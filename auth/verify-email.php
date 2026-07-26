<?php

require_once(__DIR__ . "/../helpers/functions.php");
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/session.php";



if ($_GET['token']) {
    $token = $_GET['token'];
    $hashtoken = hash("sha256", $token);
try{
    
    $email_verify_query = "SELECT * FROM email_verification WHERE token='$hashtoken'";
    $result = mysqli_query($conn, $email_verify_query);

    if (mysqli_num_rows($result) > 0) {
        $result_assoc = mysqli_fetch_assoc($result);
        $userid = $result_assoc['user_id'];

        $time = time();

        $userfetch = "select * from users where id='$userid'";
        $userinfo = mysqli_query($conn, $userfetch);
        if (mysqli_num_rows($userinfo) > 0) {
            $userdataassoc = mysqli_fetch_assoc($userinfo);
            $userquery = "update users set email_verified_at='$time' where id='$userid'";
            mysqli_query($conn, $userquery);
            mysqli_query($conn, "DELETE FROM email_verification where user_id='$userid'");
            session_regenerate_id();
            $_SESSION['user_id'] = $userid;
            $_SESSION['name'] = $userdataassoc['name'];
            $_SESSION['email'] = $userdataassoc['email'];
            redirect("/dashboard/dashboard.php");
        } else {
            redirect("auth/login.php");
        }
    }


}catch(Exception $e){
    echo "<pre>";
    var_dump($e->getMessage());
    exit;
}
} else {
    redirect("auth/login.php");
}