<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "請填寫帳號與密碼";
        exit;
    }

    // 密碼加密（建議使用 hash 存）
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, password) VALUES ($1, $2)";
    $result = pg_query_params($conn, $query, array($username, $hashedPassword));

    if ($result) {
        echo "<script>
            alert('✅ 註冊成功！即將前往登入頁面');
            window.location.href = 'login.php';
        </script>";
    } else {
        echo "❌ 註冊失敗：" . pg_last_error($conn);
    }
}
?>
<!-- 註冊表單 -->
<h2>使用者註冊</h2>
<form method="post">
    <input type="text" name="username" placeholder="帳號" required><br>
    <input type="password" name="password" placeholder="密碼" required><br>
    <button type="submit">註冊</button>
</form>
