<?php

$conn = mysqli_connect("localhost", "root", "");
if(!$conn){
    die("Connection error " . mysqli_connect_error());
}