<?php
    require 'connect.php';

    $voteType = $_POST['voteType'];
    $postId = $_POST['postId'];

    if($voteType == 1)
    {
        $query = "UPDATE content SET votes = (votes + 1) WHERE id = :id";
    }
    elseif($voteType == 2)
    {
        $query = "UPDATE content SET votes = (votes - 1) WHERE id = :id";
    }

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $postId);
    $statement->execute();
?>