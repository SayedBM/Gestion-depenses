<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['utilisateur'])) {
    // Détruire toutes les variables de session
    session_unset();

    // Détruire la session
    session_destroy();

    // Rediriger vers la page de connexion ou une autre page de votre choix
    header("Location: login.php");
    exit();
}else{
    header('Location: login.php');
}
?>