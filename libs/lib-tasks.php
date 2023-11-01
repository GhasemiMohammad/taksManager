<?php
defined("BASE_TITLE") or die("access denied");
function getFolders()
{
    global $pdo;
    $userID = getUserID();
    $sql = "SELECT * FROM folders WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result;
}
function addFolder($folderName)
{
    global $pdo;
    $currentUSerID = getUserID();
    $sql = "INSERT INTO `folders` (name,user_id) VALUES(?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$folderName, $currentUSerID]);
    return $stmt->rowCount();
}
function updateFolderName($id, $folderName)
{
    global $pdo;
    $currentUSerID = getUserID();
    $sql = "UPDATE folders SET name = :folderName WHERE id = :id and user_id= :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":folderName" => $folderName, ":id" => $id, ":userID" => $currentUSerID]);
    return $stmt->rowCount();
}
