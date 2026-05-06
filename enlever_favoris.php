<?php
session_start();
include 'create_database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$game_id = $_POST['game_id'] ?? null;

if ($game_id) {
    $sql = "DELETE FROM favoris WHERE idUser = ? AND idGame = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $game_id]);
}

header("Location: favorites.php");
exit;