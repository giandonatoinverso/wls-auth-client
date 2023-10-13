<?php
session_start();

if(!isset($_GET["callback"]) || !isset($_GET["clientId"]) || !isset($_GET["clientSecret"]))
    die("Missing parameters");

$_SESSION["callback"] = $_GET["callback"];
$_SESSION["clientId"] = $_GET["clientId"];
$_SESSION["clientSecret"] = $_GET["clientSecret"];

header("Location: login.php");

?>
