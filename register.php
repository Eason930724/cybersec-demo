<?php
include 'connect.php';

$message = '';
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

    if (!empty($username) && !empty($password)) {
        $result = pg_query_params($conn, "INSERT INTO users (username, password) VALUES ($1, $2)", array($username, $password));
        if ($result) {
            $success = true;
            $message = "註冊成功，您可以前往 <a href='login.php'>登入</a>";
        } else {
            $message = "此帳號可能已存在，請重試";
        }
    } else {
        $message = "請填寫帳號與密碼";
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>註冊</title>
</head>
<body>
    <h2>使用者註冊</h2>

    <?php if ($message): ?>
        <p style="color:<?= $success ? 'green' : 'red' ?>"><?= $message ?></p>
    <?php endif; ?>

    <?php if (!$success): ?>
        <form method="post">
            <input type="text" name="username" placeholder="帳號" required><br>
            <input type="password" name="password" placeholder="密碼" required><br>
            <button type="submit">註冊</button>
        </form>
    <?php endif; ?>
</body>
</html>
