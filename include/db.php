<?php

function connect()
{
    //todo: insérer le message en bdd si le message saisi est valide
    $dbName = "tweeter"; //nom de la base de donnée
    $dbUser = "root"; //nom d'utilisateur MySQL
    $dbPass = ""; //son mot de passe
    $dbHost = "localhost"; //l'adresse ip du serveur mysql

    //ajoutez ;port=8989 à la fin si vous devez spécifier le port de MySQL
    $dsn = "mysql:dbname=$dbName;host=$dbHost;charset=utf8";

    //cette variable $pdo contient notre connexion à la bdd \o/
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        //affiche les messages d'erreurs SQL
        //repasser à ERRMODE_SILENT en prod !!!!
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        //pour récupérer les données uniquement sous forme de tableau associatif
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}

function insertTweet($tweet, $id)
{
    $pdo = connect();
    //On utilise les parametre nomnés afin d'éviter toute injection SQL.
    //le remplacement des paramètres nommés se fait en interne de MySQL (ce n'est donc pas une
    //concaténation, d'où pas d'injection SQL possible)
    $sql = "INSERT INTO tweets (id, author_id, message, likes_quantity, date_created)
                VALUES (NULL, :id, :message, 0, NOW());";

    //echo $sql;

    $stmt = $pdo->prepare($sql);

    //remplace le tableau dans execute si on préfère
    //ou bindParam()  - cela ne peut pas etre une chaine
    //$stmt->bindValue(':message', $tweet);

    $stmt->execute([
        ":id"=> $id,
        ":message" => $tweet,
        //":date" => date("Y-m-d H:i:s")
    ]);

}

function insertUser($email, $username, $passwordHash, $bio)
{
    $pdo = connect();
    $sql = "INSERT INTO users(id, email, username, password, bio, date_created, date_updated) VALUES (NULL, :email, :username, :passwordHash, :bio, NOW(), NULL);";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":email" => $email,
        ":username" => $username,
        ":passwordHash" => $passwordHash,
        "bio" => $bio
        //":date" => date("Y-m-d H:i:s")
    ]);
}
function getUserById($userId){
    $pdo = connect();
    $sql = "SELECT `username`, `bio`, users.date_created, COUNT(tweets.message) as nb_gazouillis FROM users INNER JOIN tweets on tweets.author_id=users.id WHERE users.id = :id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":id" => $userId
    ]);
    return $stmt->fetch();
}

function getUserByEmail($email){
    $pdo = connect();
    $sql = "SELECT `email` FROM `users` WHERE `email` = :email;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":email" => $email
    ]);
    return $stmt->fetch();
}

function getUserByPseudo($pseudo){
    $pdo = connect();
    $sql = "SELECT `username` FROM `users` WHERE `username` = :pseudo;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":pseudo" => $pseudo
    ]);
    return $stmt->fetch();
}

function selectAllTweets()
{
    $pdo = connect();
    $sql = "SELECT `message`, tweets.author_id, users.username, tweets.date_created FROM tweets INNER JOIN users on users.id=tweets.author_id ORDER BY tweets.date_created DESC LIMIT 20";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

function selectTweetsById($userId)
{
    $pdo = connect();
    $sql = "SELECT `message`, tweets.author_id, users.username, tweets.date_created FROM tweets INNER JOIN users on users.id=tweets.author_id WHERE tweets.author_id = :id ORDER BY tweets.date_created DESC LIMIT 20";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":id" => $userId
    ]);
    return $stmt->fetchAll();
}

function checkIdentifiant($identifiant){
    $pdo = connect();
    $sql = "SELECT `id`, `email`, `username`, `password` FROM `users` WHERE `email`= :email;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":email" => $identifiant
    ]);
    $sql2 = "SELECT `id`, `email`, `username`, `password` FROM `users` WHERE `username`= :username;";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([
        ":username" => $identifiant
    ]);
    $result = ['email' => $stmt->fetch(),
        'pseudo' => $stmt2->fetch()];
    return $result;
}

//--------- fonctions demo select utilisées pour l'exemple dans tweet.php ---------
/*function selectTweetById($id)
{
    $pdo = connect();
    $sql = "SELECT * FROM tweets WHERE id = :id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":id"=> $id,
    ]);
    return $stmt->fetch(); //recuperation d'une seule ligne
}
*/