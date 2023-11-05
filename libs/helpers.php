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
function CheckAjaxRequest($value)
{
    if (!isset($value) && empty($value)) {
        diePage("invalid");
    }
}
function lengthSTRChecker(string $value, int $length)
{
    if (strlen($value) < $length)
        diePage("value must  be greater than $length");
}
function idChecker($id)
{
    if (strlen($id) <= 1 && !is_numeric($id)) {
        diePage("value must  be number greater and  than 1");
    }
}
