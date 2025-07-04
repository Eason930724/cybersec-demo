<?php
include("connect.php");

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    die("請填寫帳號與密碼");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$result = pg_query_params($conn,
    "INSERT INTO users (username, password) VALUES ($1, $2)",
    array($username, $hashed_password)
);

if ($result) {
    echo "註冊成功！";
} else {
    echo "註冊失敗：" . pg_last_error($conn);
}
?>
