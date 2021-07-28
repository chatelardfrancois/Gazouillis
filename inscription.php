<?php
include 'include/db.php';
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
if (!empty($_POST)){
    //////////////////// 1. récupérer les données du formulaire ////////////////////
    $email = strip_tags($_POST['email']); //strip_tags retire les balises html et empêche les attaques JS
    $pseudo = strip_tags($_POST['pseudo']);
    $password = $_POST['password'];
    $bio = strip_tags($_POST['bio']);
    $hash = password_hash($password, PASSWORD_DEFAULT, ['cost'=>14]);


    //////////////////// 2. valider les données ////////////////////

    //si email non saisi
    if (empty($email)){
        $errors['email'] = 'Veuillez saisir un email !';
        //si l'email n'est pas valide: filter_var(variable à vérifier, filtre de vérification)
    } elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email'] = 'Veuillez saisir un email valide !';
    }else{
        $emailEnBDD = getUserByEmail($email);
        if(!empty($emailEnBDD)){
            $errors['email'] = 'Cet email existe déjà';
        }
    }


    //si pseudo non saisi
    if (empty($pseudo)){
        $errors['pseudo'] = 'Veuillez saisir un pseudo SVP !';
        // vérifier si pseudo > 3 caractères et <30
    } elseif (mb_strlen($pseudo)<3 || mb_strlen($pseudo)>30){
        $errors['pseudo'] = 'Veuillez saisir un pseudo entre 3 et 30 caractères !';
    }else{
        $pseudoEnBDD = getUserByPseudo($pseudo);
        if(!empty($pseudoEnBDD)){
            $errors['pseudo'] = 'Ce pseudo existe déjà';
        }

    }

    //vérifier le mot de passe
    //https://stackoverflow.com/questions/19605150/regex-for-password-must-contain-at-least-eight-characters-at-least-one-number-a
    $regex ="/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{12,}$/";
    if (!preg_match($regex,$password)){
        $errors['password']='Veuillez choisir un mot de passe contenant au moins 12 caractères dont 1 chiffre et 1 lettre minimum';
    }

    var_dump($errors);

    //////////////////// 3. erreurs ? ////////////////////
    ///
    //si non
    if (empty($errors)){
        $passwordHash = password_hash($password, PASSWORD_DEFAULT, ['cost'=>14]);
        insertUser($email, $pseudo, $passwordHash, $bio);


        //todo: //////////////////// 6. Message flash (Session) ////////////////////
        header("Location: index.php");
        die();

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
    <h1>Créer votre compte</h1>
        <form method="post" action="" novalidate> <!-- novalidate désactive tous les contrôles html style required-->

            <label for="email">Email</label>
            <!--ternaire sur le class="input" pour modifier la classe si il y a une erreur-->
            <input class="input <?=!empty($errors['email'])? "is-danger" : ""?>"
                           type="email" name="email" id="email"
                           value="<?= $email ?? '' ?>"
                           placeholder="contact@email.fr">

            <!--if alternatif pour afficher le message d'erreur-->
            <?php if(!empty($errors['email'])): ?>
                <p><?=$errors['email']?></p>
            <?php endif; ?>

            <label for="pseudo">Pseudo</label>

            <input class="input <?=!empty($errors['pseudo'])? "is-danger" : ""?>"
                           type="text" name="pseudo" id="pseudo"
                           value="<?= $pseudo ?? '' ?>"
                           placeholder="Pseudo">

            <?php if(!empty($errors['pseudo'])): ?>
                <p><?=$errors['pseudo']?></p>
            <?php endif; ?>

            <label for="password">Mot de passe</label>

            <input class="input <?=!empty($errors['password'])? "is-danger" : ""?>"
                           type="password" name="password" id="password">

            <?php if(!empty($errors['password'])): ?>
                <p><?=$errors['password']?></p>
            <?php endif; ?>

            <label for="bio">Biographie</label>

            <textarea class="textarea" name="bio" id="bio"
                      placeholder="Présente toi"><?= $bio ?? '' ?></textarea> <!--il faut que <=$bio ?? ''?> soit collé aux balises fermantes/ouvrantes de textarea -->


            <button><strong>CREER MON COMPTE</strong></button>
        </form>

    </section>
</main>

</body>
</html>
