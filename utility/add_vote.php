<?php
    require 'connect.php';

    $postId = filter_input(INPUT_POST, 'postId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $voteType = filter_input(INPUT_POST, 'voteType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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