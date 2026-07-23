<?php

$conn = mysqli_connect("localhost", "root", "");
if (!$conn) {
    die("Connection error " . mysqli_connect_error());
}

$create_database_sql = "CREATE DATABASE IF NOT EXISTS auth_core";
$db_Created = mysqli_query($conn, $create_database_sql);
if (!$db_Created) {
    die("Database is not available " . mysqli_error($conn));
}

mysqli_select_db($conn, "auth_core");


//  Application name
define('APP_NAME', 'Core PHP Authentication');

//  base url
define('BASE_URL', 'http://localhost/codes/project/auth_core/');

//  Timezone
date_default_timezone_set('Asia/Kolkata');

//  Upload Folder
define('UPLOAD_PATH', __DIR__ . '/../assets/uploads/');

//  upload url
define('UPLOAD_URL', BASE_URL . 'assets/uploads/');

//  Mail
define('MAIL_FROM', 'zaidk4076@gmail.com');
define('MAIL_FROM_NAME', APP_NAME);
