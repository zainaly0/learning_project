<?php

require_once __DIR__. "/../middleware/authMiddleware.php";

?>

<html>
    <head>

    </head>

    <body>
        
    <h1>Profile</h1>

    <a href="<?=  url("/dashboard/edit-profile.php"); ?>">Edit profile</a>
    <a href="<?=  url("/dashboard/change-password.php"); ?>">change-password</a>
    </body>
</html>