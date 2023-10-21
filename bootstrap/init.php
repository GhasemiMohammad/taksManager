<?php
include "constants.php";
include "config.php";
include "vendor/autoload.php";
include "libs/helpers.php";

try {
    $pdo = new PDO("mysql:host=$database_config->host;dbname=$database_config->db;charset=utf8mb4", $database_config->user, $database_config->password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    diePage("failed connect to database" . $e->getMessage());
}
include "libs/lib-auth.php";
include "libs/lib-tasks.php";
