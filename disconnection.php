<?php
session_start();
    $_SESSION['identifier'] = null;
    $_SESSION['password'] = null;
    header("Location: index.php");
    exit;
?>