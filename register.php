<?php

// création des variable
$longueurLogin = 10;

$isValid = true;

$login = $_POST["login"] ?? null;
$email = $_POST["email"] ?? null;
$password = $_POST["password"] ?? null;
$confirm_password = $_POST["confirm_password"] ?? null;

// Validation
// es que les champs sont vide :
if (!$login || !$email || !$password || !$confirm_password)
{
    $isValid = false;
}

// es que login est valide :
if (!ctype_alnum($login) && strlen($login) < $longueurLogin)
{
    $isValid = false;
}

//es que l'email est valide
if (!preg_match("#^[a-z0-9]+@[a-z0-9]{2,}\.[a-z]{2,4}$#", $email))
{
    $isValid = false;
}


?>