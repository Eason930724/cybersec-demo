<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM users WHERE username = $1";
    $result = pg_query_params($conn, $query, array($username));

    if ($row = pg_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            echo "<script>
                alert('🎉 登入成功！');
                window.location.href = 'home1.php';
            </script>";
        } else {
            echo "❌ 密碼錯誤";
        }
    } else {
        echo "❌ 查無此帳號";
    }
}
?>
<!-- 登入表單 -->
<h2>使用者登入</h2>
<form method="post">
    <input type="text" name="username" placeholder="帳號" required><br>
    <input type="password" name="password" placeholder="密碼" required><br>
    <button type="submit">登入</button>
</form>
