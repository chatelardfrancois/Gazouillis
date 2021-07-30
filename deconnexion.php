<?php
session_start();
if(!empty($_SESSION["id"])){
    unset($_SESSION["id"]);
    unset($_SESSION['username']);
}

if(empty($_SESSION["id"])){
    header("Location: home.php");
}

