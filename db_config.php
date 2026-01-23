<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aesthetic_games_db_1"; // อัปเดตตามไฟล์ล่าสุด

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตั้งค่า Charset ให้ตรงกับ utf8mb4 ในไฟล์ SQL
$conn->set_charset("utf8mb4"); 
?>