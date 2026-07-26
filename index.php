<?php


require_once __DIR__ ."/config/config.php";
require_once __DIR__ . "/config/session.php";
require_once __DIR__ . "/helpers/auth.php";
require_once __DIR__ . "/helpers/functions.php";
require_once __DIR__ ."/vendor/autoload.php";

if(check()){
    redirect("/dashboard/dashboard.php");
    exit;
}



redirect("/auth/login.php");
exit;