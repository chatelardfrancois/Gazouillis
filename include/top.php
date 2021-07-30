<?php
session_start();
$id = $_SESSION['id'];
$username = $_SESSION['username'];
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="icon" type="image/png" href="media/img/faviconv2.gif"/>
    <script src="https://kit.fontawesome.com/f9102af03b.js" crossorigin="anonymous"></script>
    <title>Gazouillis - Accueil</title>
</head>
<body>
<header>
    <div>

        <input type="checkbox" id="burger">
        <label id="burger-button" for="burger">
            <i class="fas fa-user"></i>
        </label>
        <nav id="burger-content">
            <div id="nav-top">
                <h1>Informations du compte</h1>
                <label id="burger-button" for="burger">
                    <i class="fas fa-times"></i>
                </label>
            </div>
            <div id="profil-infos">
                <i id="infos-pic" class="fas fa-user"></i>
                <div id="infos-pseudo"><h1><?= $username ?></h1></div>
            </div>

            <ul>
                <li><a href="profil.php?user_id=<?=$id?>" onclick="document.getElementById('burger').click()">Profil</a></li>
                <li><a href="deconnexion.php" onclick="document.getElementById('burger').click()">Déconnexion</a></li>
            </ul>
        </nav>
        <h1>Accueil</h1>
        <div id="overlay"></div>
    </div>
</header>
