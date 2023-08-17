<?php

session_start();

if (isset($_POST["addBtn"]) && $_POST["taskName"]) {
    require_once "db_connection.php";
    $db = new DB();
    $db->create($_POST);
    session_destroy();
} else {
    $errorName = "";
    if (!$_POST["taskName"]) $errorName = "Please Fill A Task First";
    $_SESSION["errorName"] = $errorName;
    header("Location: index.php");
}
