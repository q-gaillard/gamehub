<?php
session_start();
include 'create_database.php';

// création des variable

$isValid = true;
$errorMessage = "";

$login = $_POST["login"] ?? '';
$email = $_POST["email"] ?? '';
$password = $_POST["password"] ?? '';
$confirm_password = $_POST["confirm_password"] ?? '';

// Affichage des erreurs

echo $_SESSION['error'] ?? '';
unset($_SESSION['error']); // Nettoie le message d'erreur après l'avoir affiché

// Validation
// es que les champs sont vide :
if (empty($login) || empty($email) || empty($password) || empty($confirm_password))
{
    $isValid = false;
    $errorMessage = "tout les champs ne sont pas remplie ";
}

// es que login est valide :
if (!preg_match("/^[a-zA-Z0-9]{4,}$/", $login))
{
    $isValid = false;
    $errorMessage = "le login n'est pas valide";
}

//es que l'email est valide
if (!preg_match("/^[a-z0-9\.]+@[a-z0-9\.]{2,}\.[a-z]{2,4}$/", $email))
{
    $isValid = false;
    $errorMessage = "l'email n'est pas valide";
}

//es que le mot de passe est valide
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/", $password))
{
    $isValid = false;
    $errorMessage = "le mot de passe n'est pas valide";
}

//es que le mot de passe corespond
if (!$password == $confirm_password)
{
    $isValid = false;
    $errorMessage = "votre mot de passe n'est pas identique sur les deux champs";
}

if ($isValid)
{
    $password = password_hash($password, PASSWORD_DEFAULT);

    echo "inscription réussie ! ";

    $sql = "INSERT INTO users (login, email, password) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login, $email, $password]);
    
    header("Location: login.php");
    exit;
}
else
{
    $_SESSION['error'] = $errorMessage;
    header("Location: register.php");
    exit;
}
?>