<?php
defined("BASE_TITLE") or die("access denied");
# select folders
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
#add new folder
function addFolder($folderName)
{
    global $pdo;
    $currentUSerID = getUserID();
    $sql = "INSERT INTO `folders` (name,user_id) VALUES(?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$folderName, $currentUSerID]);
    if ($stmt->rowCount() === 1) {
        $sql = "SELECT id , name FROM folders ORDER BY id DESC LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            echo $row['id'] . '-' . $row['name'];
        }
    } else {
        return null;
    }
}
#update folder name
function updateFolderName($id, $folderName)
{
    global $pdo;
    $currentUSerID = getUserID();
    $sql = "UPDATE folders SET name = :folderName WHERE id = :id and user_id= :userID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":folderName" => $folderName, ":id" => $id, ":userID" => $currentUSerID]);
    return $stmt->rowCount();
}
#delete folder 
function deleteFolder($id)
{
    global $pdo;
    $sql = "DELETE FROM Folders WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $id]);
    return $stmt->rowCount();
}

#tasks CURD
#Select tasks
function getTasks()
{
    $folder = $_GET["folderID"] ?? null;
    $folderCondition = "";
    if (isset($folder) && !empty($folder)) {
        $folderCondition = " and folder_id = $folder";
    }
    global $pdo;
    $userID = getUserID();
    $sql = "SELECT * FROM tasks WHERE user_id = ? $folderCondition";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$userID]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result;
}
#delete task
function deleteTask($taskID)
{

    global $pdo;
    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":id" => $taskID]);
    return $stmt->rowCount();
}
#add new task
function addTask($taskTitle, $folderID)
{
    global $pdo;
    $currentUSerID = getUserID();
    $sql = "INSERT INTO `tasks` (title,user_id,folder_id) VALUES(?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$taskTitle, $currentUSerID, $folderID]);
    return $stmt->rowCount();
}

#task is done or not
function changeTaskStatus($taskID)
{
    global $pdo;
    $currentUSerID = getUserID();
    $sql = "UPDATE `tasks` SET is_done =1- is_done  WHERE id =:taskID and user_id=:userID ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":taskID" => $taskID, ":userID" => $currentUSerID]);
    return $stmt->rowCount();
}
