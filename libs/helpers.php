<?php
defined("BASE_TITLE") or die("access denied");
function registerCssFile($files)
{
    if (!empty($files)) {
        foreach ($files as $file)
            echo '<link rel="stylesheet" type="text/css" href="' . $file . '" >' . PHP_EOL;
    }
}
function diePage($msg, $cssFiles = null)
{
    registerCssFile(['http://localhost:8080/taskManager/assets/css/style.css']);
    echo "<div class='dieDiv'>$msg</div>";
    die();
}
function isAjaxRequest()
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }
    return false;
}
#check ajax request set and not empty 
function CheckAjaxRequest($value)
{
    if (!isset($value) && empty($value)) {
        diePage("invalid");
    }
}
#check input length 
function lengthSTRChecker(string $value, int $length)
{
    if (strlen($value) < $length)
        diePage("value must  be greater than $length");
}
#check input length not be less than 1 and not be string 
function idChecker($id)
{
    if (!isset($id) &&  !is_numeric($id)) {
        diePage("value must  be number and greater than 1");
    }
}
function validFolderURl($folderID)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM folders WHERE id = :folderID");
    $stmt->bindParam(':folderID', $folderID, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    if ($count == 1 || $folderID == 0) {
        return true;
    } else {
        return false;
    }
}
#die and dump function for print Database result or anythings
function dd($var)
{
    echo "<pre class='popUp'>";
    var_dump($var);
    echo "</pre>";
}
function siteURL($uri)
{
    return BASE_URL . $uri;
}
