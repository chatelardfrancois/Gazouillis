<?php
include 'include/db.php';
session_start();
if(empty($_SESSION["id"])){
    header("Location: home.php");
}
//Je traite ici mon formulaire

$error = "";

//la variable $_POST va contenir ou pas les données du formulaire.
//var_dump($_POST);
//var_dump($_GET);
//je ne dois pas pouvoir envoyer des donnees en get cad via l'url
if (!empty($_GET)){
    //redirection vers une page 404 (page non trouvée)
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
}

//est-ce-que le formulaire est soumis?
if(!empty($_POST)){
    //s'il n'est pas vide...

    //On récupère les données du form que l'on stocke dans nos variables
    //strip_tags() --> supprime les balises HTML potentiellement injectées dans le textarea
    $tweet = strip_tags($_POST['tweet']);

    //Validation des données

    //Vérifier que le champ texte n'est pas vide
    if(empty($tweet)){
        $error = "Veuillez écrire quelque chose svp";

        //Vérifier que le message ne contient pas plus de 255 caractères
    } elseif (mb_strlen($tweet) > 255){
        $error = "Vous ne pouvez pas saisir plus de 255 caractères !";
    }

    if($error == "") {
        //insérer le message en bdd si le message saisi est valide
        insertTweet($tweet, $_SESSION["id"]);

        //------- exemples pour montrer les différents select
        /*        $results = selectAllTweets();
                var_dump($results);
                //pour traiter le resultat faire un foreach (c'est un tableau associatif dans un tableau)
                foreach ($results as $result){
                    echo $result['message'].'-'.$result['author_id'].'<br>';
                }

                $result = selectTweetById(1);
                var_dump($result);
                //pour traiter le resultat (c'est un tableau associatif)
                echo $result['message'].'-'.$result['author_id'].'<br>';
        */        //fin du test


        header("Location: index.php");
        die();
    }
}

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gazouiller.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="icon" type="image/png" href="media/img/faviconv2.gif"/>
    <script src="https://kit.fontawesome.com/f9102af03b.js" crossorigin="anonymous"></script>
    <title>Gazouillis - Gazouiller</title>
</head>
<body>
<header>
    <div>


        <label id="burger-button" for="burger">
            <i class="fas fa-arrow-left" onclick="history.back()"></i>
        </label>

        <button id="gazouiller" onclick="document.getElementById('form').submit()" disabled>Gazouiller</button>
        <div id="overlay"></div>
    </div>
</header>
<main>
    <section id="content">
        <div class="left">
            <i class="fas fa-user" id="profile-pic"></i>
        </div>
        <div class="right">
            <form method="post" novalidate="novalidate" id="form">
                <textarea onkeyup="countChars(this);" maxlength="255" name="tweet" class="textarea <?= !empty($error) ? "is-danger" : "" ?>" id="tweet_input"
                          placeholder="Quoi de neuf ?"><?= $tweet ?? "" ?></textarea>
                        <?php
                        //cette ecriture ($tweet ?? "") est equivalente à (isset($tweet)?$tweet:"") -> operateur de fusion null
                        //on utilise ici l'opérateur Null coalescent (??) qui a été ajouté comme un sucre syntaxique pour
                        // les cas de besoin les plus communs d'utiliser une troisième conjonction avec la fonction isset().
                        // Il retourne le premier opérande s'il existe et n'a pas une valeur null; et retourne le second opérande sinon.
                        ?>
                <script type="text/javascript">
                    function countChars(obj){
                        var maxLength = 255;

                        if(obj.value.trim().length>0){
                            document.getElementById("gazouiller").disabled=false;
                        }else{
                            document.getElementById("gazouiller").disabled=true;
                        }

                        if(obj.value.length === maxLength){
                            var strLength = obj.value.length;
                            document.getElementById("charNum").innerHTML = '<span style="color: red;">'+strLength+'</span>';
                        }else{
                            document.getElementById("charNum").style.visibility = "visible";
                            document.getElementById("charNum").innerHTML = obj.value.length;
                        }
                        if(obj.value.trim().length===0){
                            document.getElementById("charNum").style.visibility = "hidden";
                        }
                    }
                </script>

                    <?php if($error != "") : ?>
                        <p class="help is-danger"> <?= $error ?> </p>
                    <?php endif; ?>
                <div style="display: flex;">
                    <i id="add" class="far fa-image"></i>
                    <i id="add" class="far fa-smile"></i>
                    <div id="charNum">0</div>
                </div>
            </form>
        </div>
    </section>
</main>