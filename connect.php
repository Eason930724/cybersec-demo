<?php
$host = "dpg-d1jpbuu3jp1c73ej4b50-a.oregon-postgres.render.com";
$port = "5432";
$dbname = "cybersec_296b";
$user = "user";
$password = "V1lgAAKlfBFtV68DcoW9UWmMup0Pjiw5";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("連線失敗：" . pg_last_error());
}
?>
