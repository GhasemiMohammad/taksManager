<?php

include_once "../bootstrap/init.php";
if (!isAjaxRequest()) {
    diePage("invalid request");
}
$action = $_POST["action"];

CheckAjaxRequest($action);

switch ($action) {
    case "addFolder":
        $folderName = $_POST["folderName"];
        CheckAjaxRequest($folderName);
        lengthChecker($folderName, 2);
        echo addFolder($folderName);
        break;
    case "changeFolderName":
        $folderID = $_POST["folderID"];
        $folderNewName = $_POST["folderNewName"];
        CheckAjaxRequest($folderID);
        CheckAjaxRequest($folderNewName);
        lengthChecker($folderNewName, 2);
        echo updateFolderName($folderID, $folderNewName);
        break;
    default:
        diePage("invalid action");
        break;
}
