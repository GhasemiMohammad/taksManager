<?php
session_start();
include "constants.php";
defined("BASE_TITLE") or die("access denied");
include BASE_PATH . "bootstrap/config.php";
include BASE_PATH . "vendor/autoload.php";
include BASE_PATH . "libs/helpers.php";

try {
    $pdo = new PDO("mysql:host=$database_config->host;dbname=$database_config->db;charset=utf8mb4", $database_config->user, $database_config->password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    diePage("failed connect to database" . $e->getMessage());
}
include BASE_PATH . "libs/lib-auth.php";
include BASE_PATH . "libs/lib-tasks.php";
