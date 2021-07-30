<?php
session_start();
if(!empty($_SESSION["id"])){
    header("Location: index.php");
}
?>
<a href="inscription.php">Inscription</a>
<a href="connexion.php">Connexion</a>
