<?php

require_once __DIR__ . "/../config/session.php";
require_once __DIR__ . "/../helpers/functions.php";

if (!isset($_SESSION['user_id'])) {
    redirect("/auth/login.php");
}


echo "<PRE>";
var_dump($_SESSION);
echo $_SESSION['name'];

