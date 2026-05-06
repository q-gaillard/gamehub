<?php
session_start();
include 'create_database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
$game_id = $_POST['game_id'] ?? null;

if ($game_id)
    {
        $sql = "INSERT INTO favoris (idUser, idGame) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);

        try
        {
            $stmt->execute([$user_id, $game_id]);
        }
        catch (PDOException $e)
        {
            echo "erreur : " + $e;
        }
    }

header("Location: favorites.php");
exit;