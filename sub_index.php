<?php
    require 'utility/connect.php';
    require 'utility/utility.php';
    session_start();

    $subbreddit = filter_input(INPUT_GET, 'subbreddit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT c.id, c.title, c.post, c.votes, c.userid, c.subbredditid, c.thumbnail, c.imagename, c.posttype, u.username, s.name
              FROM content c JOIN subbreddit s ON s.id = c.subbredditid JOIN users u ON c.userid = u.id WHERE s.name = :subbreddit";
    $values = $db->prepare($query);
    $values->bindValue(':subbreddit', $subbreddit);
    $values->execute();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
    <title><?= $subbreddit ?></title>
  </head>
  <body>
    <div style="display: none" id="hideAll">&nbsp;</div>
    <script type="text/javascript">
      document.getElementById("hideAll").style.display = "block";
    </script> 

    <?php include 'header.php'; ?>
    <div id="wrapper">
      <div id="content">
        <?php include 'sidebar.php'; ?>
        <div id='main'>
        
        </div>
      </div>
    </div>

    <div class="loadmore">
      <a id="load">Load More</a>
    </div>
    <?php include 'footer.php'; ?>
    <script type="text/javascript">
      document.getElementById("hideAll").style.display = "none"; 
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
