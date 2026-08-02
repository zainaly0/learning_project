<?php
 
require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../helpers/functions.php";

if(isset($_SESSION['user_id'])){
    redirect("/dashboard/dashboard.php");
}