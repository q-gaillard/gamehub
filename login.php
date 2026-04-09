<?php
session_start();
include 'create_database.php';

$isValid = true;
$errorMessage = "";

// Validation
// vérifié si le mot de passe et l'identifiant et le bon
$login = $_POST["identifier"] ?? '';
$password = $_POST["password"] ?? '';

// es que les champs sont vide :
if (empty($login) || empty($password))
{
    $isValid = false;
    $errorMessage = "tout les champs ne sont pas remplie ";
}
// es que login est valide :
else if (!preg_match("/^[a-zA-Z0-9]{4,}$/", $login))
{
    $isValid = false;
    $errorMessage = "le login n'est pas valide";
}
//es que le mot de passe est valide
else if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/", $password))
{
    $isValid = false;
    $errorMessage = "le mot de passe n'est pas valide";
}

// vérification SQL
if ($isValid)
{
    $sql = "SELECT password FROM users WHERE login = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login]);

    $result = $stmt->fetch();

    if ($result)
    {
        $TruePassword = $result['password'];
        $TruePassword = password_hash($TruePassword, PASSWORD_DEFAULT);

        if ($TruePassword != $password)
        {
            $isValid = false;
            $errorMessage = "Votre identifiant ou votre mot de passe est incorrect";
        }
    }
}

if ($isValid)
{
    $_SESSION['identifier'] = $login;
    $_SESSION['user_id'] = $result['id'];
    header("Location: index.php");
    exit;
}
else
{
    echo $errorMessage;
}
?>
