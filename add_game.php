<?php
session_start();
include 'create_database.php';

$errorMessage = "";
$isValid = true;

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
    $sql = "INSERT INTO games (title, genre, description, image, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $genre, $description, $image, $_SESSION['user_id']]);
}

header("Location: index.php");
exit;

?>