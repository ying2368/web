<?php
require_once '../config.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => '請先登入']);
    exit;
}

$student_id = $_SESSION['user_id'];
$teacher_id = $_POST['teacher'];
$classroom = $_POST['classroom'];
$date = $_POST['date'];
$time_slot = $_POST['time_slot'];

$start_time = $date . ' ' . $time_slot;
$end_time = date('Y-m-d H:i:s', strtotime($start_time . ' +1 hour'));

// 檢查衝突
$check_sql = "SELECT COUNT(*) as count FROM courses 
              WHERE classroom = ? 
              AND ((start_time <= ? AND end_time > ?) 
              OR (start_time < ? AND end_time >= ?))";

$stmt = $conn->prepare($check_sql);
$stmt->bind_param("sssss", $classroom, $end_time, $start_time, $end_time, $start_time);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($result['count'] > 0) {
    echo json_encode(['success' => false, 'message' => '該時段已被預約']);
    exit;
}

// 新增預約
$insert_sql = "INSERT INTO courses (name, teacher_id, classroom, start_time, end_time, capacity) 
               VALUES (?, ?, ?, ?, ?, 1)";

$course_name = "預約課程";
$capacity = 1;

$stmt = $conn->prepare($insert_sql);
$stmt->bind_param("sisss", $course_name, $teacher_id, $classroom, $start_time, $end_time);

if ($stmt->execute()) {
    $course_id = $conn->insert_id;
    
    // 記錄預約
    $booking_sql = "INSERT INTO bookings (student_id, course_id) VALUES (?, ?)";
    $stmt = $conn->prepare($booking_sql);
    $stmt->bind_param("ii", $student_id, $course_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => '預約記錄失敗']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '課程創建失敗']);
}
?>