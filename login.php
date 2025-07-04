<?php
include 'connect.php';
session_start();

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        $result = pg_query_params($conn, "SELECT * FROM users WHERE username = $1", array($username));
        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["username"] = $user["username"];
            header("Location: home1.php");
            exit;
        } else {
            $message = "帳號或密碼錯誤";
        }
    } else {
        $message = "請填寫帳號與密碼";
    }
}
?>

<!DOCTYPE html>
<html lang=\"zh-Hant\">
<head>
    <meta charset=\"UTF-8\">
    <title>登入</title>
</head>
<body>
    <h2>使用者登入</h2>
    <form method=\"post\">
        <input type=\"text\" name=\"username\" placeholder=\"帳號\" required><br>
        <input type=\"password\" name=\"password\" placeholder=\"密碼\" required><br>
        <button type=\"submit\">登入</button>
    </form>
    <p><?= htmlspecialchars($message) ?></p>
    <a href=\"register.php\">註冊新帳號</a>
</body>
</html>
