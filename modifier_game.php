<?php
session_start();
include 'create_database.php';

$errorMessage = "";
$isValid = true;

$game_id = $_POST['game_id'] ?? null;

if (!isset($_SESSION['identifier']))
{
    header("Location: login.html");
    exit;
}
$title = $_POST["title"] ?? '';
$genre = $_POST["genre"] ?? '';
$description = $_POST["description"] ?? '';
$image = $_POST["image"] ?? '';

if (empty($title) || empty($genre) || empty($description) || empty($image))
{
    $isValid = false;
    $errorMessage = "tout les champs ne sont pas remplie ";
}

if ($isValid)
{
    $sql = "UPDATE games SET title = ?, genre = ?, description = ?, image = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $genre, $description, $image, $game_id ]);
}

header("Location: index.php");
exit;

?>