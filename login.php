<?php
include("connect.php");

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    die("請填寫帳號與密碼");
}

$result = pg_query_params($conn,
    "SELECT * FROM users WHERE username = $1",
    array($username)
);

if ($row = pg_fetch_assoc($result)) {
    if (password_verify($password, $row['password'])) {
        echo "登入成功，歡迎 " . htmlspecialchars($username);
    } else {
        echo "密碼錯誤";
    }
} else {
    echo "找不到帳號";
}
?>
