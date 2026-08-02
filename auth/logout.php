<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../helpers/functions.php";

if(!isset($_SESSION['user_id'])){
    redirect("/auth/login.php");
}

if (!isset($_COOKIE['remember_token'])) {
    redirect("/auth/login.php");
    exit;
}

$remember_token = hash('sha256', $_COOKIE['remember_token']);

$remtoken_sql = "select * from remember_tokens where token='$remember_token'";

$stmt = $conn->prepare("select * from remember_tokens where token=?");
$stmt->bind_param('s', $remember_token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = mysqli_fetch_object($result);

    $user_id = $data->user_id;
    $ip_address = $_SERVER['SERVER_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $logout_at = time();
    $login_at = time();
    $login_status = 'success';

    $login_history = "insert into login_history(user_id, ip_address, user_agent, login_at, logout_at, login_status) value('$user_id', '$ip_address', '$user_agent', '$login_at', '$logout_at', '$login_status')";

    if (mysqli_query($conn, $login_history)) {

        $delete_remtoken = mysqli_query($conn, "delete from remember_tokens where token='$remember_token'");
        if ($delete_remtoken) {
            $_SESSION = [];
            session_destroy();
            setcookie('PHPSESSID', "", time()-3000);
            setcookie('remember_token', "", time()-3000);
            redirect('/auth/login.php');
            exit;
        }
    }
}
