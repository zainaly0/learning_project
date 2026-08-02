<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../helpers/functions.php";

if(isset($_SESSION['user_id'])){
    redirect("/auth/login.php");
}