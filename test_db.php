<?php
include 'connect.php';

$result = pg_query($conn, "SELECT * FROM users");
if (!$result) {
    echo "查詢失敗：" . pg_last_error();
} else {
    echo "✅ 成功連線並查詢 users 資料表<br>";
    while ($row = pg_fetch_assoc($result)) {
        echo "👤 " . htmlspecialchars($row['username']) . "<br>";
    }
}
?>
