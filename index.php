<?php
include "bootstrap/init.php";

if (isset($_GET['deleteTask']) && is_numeric($_GET['deleteTask'])) {
    $deleteCount = deleteTask($_GET['deleteTask']);
}
$folders = getFolders();
$tasks = getTasks();

include "TPL/TPL-index.php";
