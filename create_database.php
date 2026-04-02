<?php
    $pdo = new PDO("mysql:host=localhost;charset=utf8", "root", "");
    include 'db.php';

    // créer la base de données gamehub
    $sql = "CREATE DATABASE IF NOT EXISTS gamehub";
    $pdo->exec($sql);

    // crée la table users
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";
    $pdo->exec($sql);

    // crée la table games
    $sql = "CREATE TABLE IF NOT EXISTS games (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        genre VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        image VARCHAR(255) NOT NULL
        user_id INT NOT NULL,
    )";
    $pdo->exec($sql);
?>
