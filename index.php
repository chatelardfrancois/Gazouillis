<?php
include 'include/top.php';
include 'include/db.php';
if(empty($_SESSION["id"])){
    header("Location: home.php");
}
$results = selectAllTweets();
?>
<main>
<section id="content">
    <?php
include 'include/gazouillis.php';
?>

</section>
<a id="gazouiller" href="gazouiller.php"><i class="fas fa-feather-alt"></i><span id="gazouiller-text">Gazouiller</span></a>
</main>

<?php
include 'include/bottom.php'
?>
