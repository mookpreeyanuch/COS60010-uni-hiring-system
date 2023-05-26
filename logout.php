<?php

session_set_cookie_params(3600);
session_start();

include_once("settings.php");
include_once("functions.php");
include_once("db-conn.php");
include_once("create-table.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && checkLogin()) {
    unset($_SESSION["id"]);
    unset($_SESSION["username"]);
    unset($_SESSION["logged_in"]);

    unset($_SESSION["flash_login_attempt"]);
    unset($_SESSION["flash_login_attempt_again"]);

    redirect("manage.php", false);
} else {
    redirect("manage.php", false);
}
?>