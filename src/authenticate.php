<?php

require_once 'config/config.php';
require_once BASE_PATH . '/lib/OauthServerConnector/OauthServerConnector.php';
session_start();

if(!isset($_SESSION["callback"]) ||
    !isset($_SESSION["clientId"]) ||
    !isset($_SESSION["clientSecret"]) ||
    !isset($_SESSION["client_name"])
)
    die("Missing session parameters");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION["username"] = filter_input(INPUT_POST, 'username');
    $password = md5(filter_input(INPUT_POST, 'password'));

    $userInfoToken = null;
    try {
        $userInfoToken = $_SESSION["oauthServerConnector"]->getUserInfo($_SESSION["username"], $password);
        $_SESSION["userInfoToken"] = $userInfoToken["data"];
        header("Location: consent.php");

    } catch(Exception $e) {
        $httpCode = $e->getCode();
        $error = $e->getMessage();

        $_SESSION['login_failure'] = $httpCode . " " . $error;
        header('Location: login.php');
        exit;
    }

}
else {
    die('GET method not allowed');
}
