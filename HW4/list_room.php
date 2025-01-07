<?php
// 資料庫連線設定
$host = "localhost";        // 資料庫伺服器
$username = "your_username"; // 資料庫使用者名稱
$password = "your_password"; // 資料庫密碼
$dbname = "your_database";   // 資料庫名稱

// 建立資料庫連線
$mysqli = new mysqli($host, $username, $password, $dbname);

// 檢查連線是否成功
if ($mysqli->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $mysqli->connect_error]));
}

// 查詢所有房間
$query = "SELECT id, room_name FROM rooms";
$result = $mysqli->query($query);

// 建立房間列表
$rooms = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

// 回傳 JSON 格式的房間列表
header("Content-Type: application/json");
echo json_encode($rooms);

// 關閉資料庫連線
$mysqli->close();
?>