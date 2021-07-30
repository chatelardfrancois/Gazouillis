<?php
include 'include/db.php';
session_start();
if(!empty($_SESSION["id"])){
    header("Location: index.php");
}
//initialisation tableau associatif des éventuelles erreurs
$errors = [];

//pour éviter les manip sur l'URL
if (!empty($_GET)){
    header("HTTP/1.1 404 NotFound");
    include '404.php';
    die();
}

//var_dump($_POST); //affiche les données saisies dans le formulaire sous forme d'un tableau
//die(); pour arrêter l'excecution de la suite

//vérifier que le formulaire est soumis
if (!empty($_POST)) {
//////////////////// 1. récupérer les données du formulaire ////////////////////
//strip_tags retire les balises html et empêche les attaques JS
    $identifiant = strip_tags($_POST['identifiant']);
    $password = $_POST['password'];

//////////////////// 2. valider les données ////////////////////

    if (empty($identifiant)) {
        $errors['identifiant'] = 'Veuillez saisir votre identifiant !';
    } else {
        $result= checkIdentifiant($identifiant);
        if($result['email']==false and $result['pseudo']==false){
            $errors['identifiant'] = 'Identifiant inconnu';
        } else{
            if($result['email']!=false) {
                $boolean = password_verify($password, $result['email']['password']);
            } else{
                $boolean = password_verify($password, $result['pseudo']['password']);
            }

            if($boolean==false){
                $errors['mdp'] = 'Mot de passe incorrect';
            } else{
                if($result['email']!=false){
                    $_SESSION["id"]=$result['email']['id'];
                    $_SESSION["username"]=$result['email']['username'];
                } else{
                    $_SESSION["id"]=$result['pseudo']['id'];
                    $_SESSION["username"]=$result['pseudo']['username'];
                }
                header("Location: index.php");
            }
        }
    }
}
?>

<!doctype html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/inscription.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="icon" type="image/png" href="media/img/faviconv2.gif"/>
    <script src="https://kit.fontawesome.com/f9102af03b.js" crossorigin="anonymous"></script>
    <title>Gazouillis - Inscription</title>
</head>
<body>
<header>
    <i class="fas fa-dove"></i>
</header>
<main>
    <section id="content">
        <h1>Connexion</h1>
        <form method="post" action="" novalidate> <!-- novalidate désactive tous les contrôles html style required-->

            <label for="identifiant">Identifiant</label>

            <input type="text" name="identifiant" id="identifiant"
                   value="<?= $pseudo ?? '' ?>"
                   placeholder="Email ou pseudo">

            <?php if(!empty($errors['identifiant'])): ?>
                <p><?=$errors['identifiant']?></p>
            <?php endif; ?>

            <label for="password">Mot de passe</label>

            <input type="password" name="password" id="password">
            <?php if(!empty($errors['mdp'])): ?>
                <p><?=$errors['mdp']?></p>
            <?php endif; ?>

            <button><strong>Connexion</strong></button>
        </form>

    </section>
</main>

</body>
</html>
