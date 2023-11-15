<?php
include "bootstrap/init.php";


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_GET['action'];
    $parameters = $_POST;
    if ($action == "register") {
        $result = register($parameters);
        if (!$result) {
            diePage("an error in Registration!");
        } else {
            message("every things is good. welcome", "success");
        }
    } elseif ($action == "login") {
        $result = login($parameters["email"], $parameters["password"]);
        if (!$result) {
            message("email or password is incorrect");
        } else {
            redirect(siteURL());
        }
    }
}

include "TPL/TPL-auth.php";
