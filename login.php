<?php
// session start
session_start();

// création des variable

$isValid = true;
$errorMessage = "";

$login = $_POST["identifier"] ?? '';
$password = $_POST["password"] ?? '';

// Validation
// vérifié si le mot de passe et l'identifiant et le bon
if ($login != $_SESSION['identifier'] || $password != $_SESSION['password'])
{
    $isValid = false;
    $errorMessage = "votre identifiant ou votre mot de passe est incorrecte";
}

// es que les champs sont vide :
if (empty($login) || empty($password))
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

//es que le mot de passe est valide
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/", $password))
{
    $isValid = false;
    $errorMessage = "le mot de passe n'est pas valide";
}

if ($isValid)
{
    $_SESSION['identifier'] = $login;
    $_SESSION['password'] = $password;
    header("Location: index.php");
    exit;
}
else
{
    echo $errorMessage;
}
?>