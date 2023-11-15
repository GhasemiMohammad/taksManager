<?php
include "bootstrap/init.php";
if (isset($_GET["logout"])) {
    logout();
}
if (!loggedIn()) {

    // redirect(siteURL('auth.php'));
    redirect(siteURL('auth.php'));
}
$user = getLoggedInUser();
if (isset($_GET['deleteTask']) && is_numeric($_GET['deleteTask'])) {
    $deleteCount = deleteTask($_GET['deleteTask']);
}
$folders = getFolders();
$tasks = getTasks();

include "TPL/TPL-index.php";
