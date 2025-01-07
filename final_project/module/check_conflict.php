<?php
require_once '../config.php';
header('Content-Type: application/json');

$date = $_POST['date'];
$time_slot = $_POST['time_slot'];
$classroom = $_POST['classroom'];

$start_time = $date . ' ' . $time_slot;
$end_time = date('Y-m-d H:i:s', strtotime($start_time . ' +1 hour'));

$sql = "SELECT COUNT(*) as count FROM courses 
        WHERE classroom = ? 
        AND ((start_time <= ? AND end_time > ?) 
        OR (start_time < ? AND end_time >= ?))";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $classroom, $end_time, $start_time, $end_time, $start_time);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode(['conflict' => $result['count'] > 0]);
?>