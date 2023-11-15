<?php
defined("BASE_TITLE") or die("access denied");

function emailValidation($email)
{
    $inputValidation = inputValidation($email, 5);
    if ($inputValidation === false)
        return false;

    global $pdo;
    $sql = "SELECT count(*) FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":email" => $email]);
    $result = $stmt->fetchAll(PDo::FETCH_ASSOC);

    if ($result[0]["count(*)"] != 0) {
        echo "<script>alert('email is exist');</script>";
        return false;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}
function passwordValidation($password)
{
    if (inputValidation($password, 8) === false)
        return false;
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[@!*#^&()-+$%]/', $password)) {
        message("weak password. use number,upper and lower case character and special character");
        return false;
    }
    return true;
}
function register($userData)
{
    $email = $userData['email'];
    if (emailValidation($email) === false)
        return false;
    if (passwordValidation($userData['password']) === false)
        return false;
    $name = $userData['name'];
    $hashPassword = password_hash($userData['password'], PASSWORD_BCRYPT);
    global $pdo;
    $sql = "INSERT INTO users (name,password,email) VALUES (?,?,?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $hashPassword, $email]);
    return $stmt->rowCount() ? true : false;
}
function getUserByEmail($email)
{
    global $pdo;
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["email" => $email]);
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $result[0] ?? null;
}
function login($email, $password)
{
    $user = getUserByEmail($email);

    if (is_null($user))
        return false;

    if (password_verify($password, $user->password)) {
        $user->image = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->email)));
        $_SESSION['user'] = $user;
        return true;
    }

    return false;
}
function logout()
{
    unset($_SESSION['user']);
}

function loggedIn()
{
    return isset($_SESSION['user']) ? true : false;
}
function getLoggedInUser()
{
    return $_SESSION['user'] ?? null;
}
function getUserID()
{
    return getLoggedInUser()->id ?? null;
}
