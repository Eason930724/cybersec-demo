<?php
// 開啟 session
session_start();

// 清除所有 session 變數
session_unset();

// 銷毀 session
session_destroy();

// 導回首頁
header("Location: index.php");
exit;
?>
