<?php
foreach ($results as $result){
    $author_id = $result['author_id'];
    $originalDate = $result['date_created'];
//original date is in format YYYY-mm-dd
    $timestamp = strtotime($originalDate);
    $newDate = date("d-m-Y", $timestamp );
    $dt = new DateTime($originalDate);
    $time = $dt->format('H:i:s');
    echo "<div id='gazouillis'>";
    echo "<div id='gazouillis-pic'>";
    echo "<i class='fas fa-comment-dots'></i>";
    echo "</div>";
    echo "<div id='gazouillis-infos'>";
    echo "<div id='gazouillis-pseudo'>";
    echo "<a href='profil.php?user_id=$author_id'>".$result['username']."</a>"."<span id='gazouillis-date'>"."le ".$newDate." à ".$time."</span>";
    echo "</div>";
    echo "<div id='gazouillis-message'>";
    echo $result['message'];
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
?>
