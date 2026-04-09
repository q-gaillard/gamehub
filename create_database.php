<?php
    $pdo = new PDO("mysql:host=localhost;charset=utf8", "root", "");

    // créer la base
    $pdo->exec("CREATE DATABASE IF NOT EXISTS gamehub");

    // utiliser la base
    $pdo->exec("USE gamehub");

    // table users
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        login VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    )");

    // table games
    $pdo->exec("CREATE TABLE IF NOT EXISTS games (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        genre VARCHAR(255) NOT NULL,
        description TEXT NOT NULL,
        image VARCHAR(255) NOT NULL,
        user_id INT NOT NULL
    )");
?>