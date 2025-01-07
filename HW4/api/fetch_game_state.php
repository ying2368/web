<?php
$roomId = $_GET['room_id'];

$mysqli = new mysqli("localhost", "username", "password", "database");
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

$query = "SELECT player_data, board_state, current_player FROM game_state WHERE room_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $roomId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["status" => "error", "message" => "Game state not found"]);
}
?>