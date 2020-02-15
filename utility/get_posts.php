<?php
    include 'utility.php';
    session_start();

    if(isset($_GET['initial']))
    {
        $_SESSION['page'] = 0;
    }

    if(isset($_GET['page']))
    {        
        $_SESSION['page'] += 1;
    }

    $limit = 15;
    
    $query = "SELECT c.id, c.title, c.post, c.votes, c.downvotes, c.userid, c.subbredditid, c.imagename, c.thumbnail, c.posttype, c.date, s.name, u.username, u.id AS userid 
    FROM content c JOIN subbreddit s ON s.id = c.subbredditid JOIN users u ON c.userid = u.id GROUP BY c.id LIMIT ".$limit." OFFSET ".$_SESSION['page'] * $limit;

    $posts = pullData($query);
    generatePosts($posts);
?>