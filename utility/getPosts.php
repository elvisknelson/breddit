<?php
    include 'utility.php';

    session_start();
    $limit = 10;
    $page = $_SESSION['page'] * $limit - $limit;

    $query = "SELECT c.id, c.title, c.post, c.votes, c.downvotes, c.userid, c.subbredditid, c.imagename, c.thumbnail, c.posttype, c.date, s.name, u.username, u.id AS userid 
    FROM content c JOIN subbreddit s ON s.id = c.subbredditid JOIN users u ON c.userid = u.id GROUP BY c.imagename LIMIT ".$limit." OFFSET ".$page;

    $posts = pullData($query);
    generatePosts($posts);
    $_SESSION['page'] = $_SESSION['page'] + 1;
?>