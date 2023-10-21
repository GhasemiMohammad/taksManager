<?php
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
