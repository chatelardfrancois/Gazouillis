<?php
include 'include/db.php';
session_start();
if(empty($_SESSION["id"])){
    header("Location: home.php");
}
//si mon tableau associatif $_GET est vide, ce n'esp aps normale et je redirige vers une 404
if (empty($_GET)){
    //redirection vers une page 404 (page non trouvée)
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
} elseif (!isset($_GET['user_id'])) {
    //redirection vers une page 404 (page non trouvée)
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
} else if (count($_GET)>= 2) {
    //redirection vers une page 404 (page non trouvée)
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
}

    $userId = $_GET['user_id'];

//appelle notre fonction pour récupérer les infos de cet user
$user = getUserById($userId);

if (!isset($user)) {
    //redirection vers une page 404 (page non trouvée)
    header("HTTP/1.1 404 Not Found");
    include("404.php");
    die();
}

$results = selectTweetsById($userId);

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/profil.css">
    <link rel="stylesheet" href="css/media.css">
    <link rel="icon" type="image/png" href="media/img/faviconv2.gif"/>
    <script src="https://kit.fontawesome.com/f9102af03b.js" crossorigin="anonymous"></script>
    <title>Gazouillis - Profil</title>
</head>

<body>
<header>
    <div>


        <label id="burger-button" for="burger">
            <i class="fas fa-arrow-left" onclick="history.back()"></i>

        </label>
        <div>
        <h1><?= $user['username'] ?></h1>
        <div id="nb"><?= $user['nb_gazouillis'] ?> gazouillis</div>
        </div>
    </div>
</header>
<main>
    <section id="content">
        <div id="profil-infos">
            <i id="infos-pic" class="fas fa-user"></i>
            <div id="infos-pseudo"><h1><?= $user['username'] ?></h1></div>
            <div id="infos-bio"><?= $user['bio'] ?></div>
            <div id="infos-date"><i class="far fa-calendar-alt"></i> A rejoint Gazouillis en <?= $user['date_created'] ?> </div>

        </div>
        <div id="profil-nav">
            <script>
                function click1(){
                    var x = document.getElementById('test');
                    document.getElementById('profil-gazouillis').checked=false;
                    document.getElementById('profil-jaime').checked=true;


                }
                function click2(){
                    var x = document.getElementById('test');
                    document.getElementById('profil-jaime').checked=false;
                    document.getElementById('profil-gazouillis').checked=true;

                }
            </script>
            <input type="checkbox"  id="profil-gazouillis" style="display: none" checked>
            <input type="checkbox" id="profil-jaime" style="display: none">
            <div id="a" onclick="click2()"><div style="width: min-content;"><div id="nav-text">Gazouillis</div><div id="barre"></div></div></div>
            <div id="b" onclick="click1()"><div style="width: min-content;"><div id="nav-text">J'aime</div><div id="barre"></div></div></div>
        </div>
        <div id="test">
            <?php
            include 'include/gazouillis.php'
            ?>
        </div>

    </section>
    <a id="gazouiller" href="gazouiller.php"><i class="fas fa-feather-alt"></i><span id="gazouiller-text">Gazouiller</span></a>

</main>
<?php
include 'include/bottom.php'
?>

</body>