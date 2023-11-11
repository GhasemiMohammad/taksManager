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
        lengthSTRChecker($folderName, 2);
        echo addFolder($folderName);
        break;
    case "changeFolderName":
        $folderID = $_POST["folderID"];
        $folderNewName = $_POST["folderNewName"];
        CheckAjaxRequest($folderID);
        idChecker($folderID);
        CheckAjaxRequest($folderNewName);
        lengthSTRChecker($folderNewName, 2);
        echo updateFolderName($folderID, $folderNewName);
        break;
    case "deleteFolder":
        $folderID = $_POST["folderID"];
        idChecker($folderID);
        echo deleteFolder($folderID);
        break;
    case "addTask":
        $taskTitle = $_POST["taskTitle"];
        $folderID = $_POST["folderID"];
        idChecker($folderID);
        lengthSTRChecker($taskTitle, 2);
        echo addTask($taskTitle, $folderID);
        break;
    case "switchDone":
        $taskID = $_POST['taskID'];
        idChecker($taskID);
        changeTaskStatus($taskID);
        break;
    default:
        diePage("invalid action");
        break;
}
