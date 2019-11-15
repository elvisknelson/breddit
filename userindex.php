<?php
  require 'connect.php';
  require 'utility.php';
  session_start();

  $username = $_GET['username'];

  $query = "SELECT c.id, c.title, c.post, c.votes, c.userid, c.subbreddit, c.thumbnail, c.posttype, u.username FROM content c JOIN users u ON c.userid = u.id WHERE u.username = (:username)";
  $values = $db->prepare($query);
  $values->bindValue(':username', $username);
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
    <title>breddit</title>
  </head>
  <body>
    <div style="display: none" id="hideAll">&nbsp;</div>
    <script type="text/javascript">
      document.getElementById("hideAll").style.display = "block";
    </script>
    <?php include 'header.php'; ?>
    <div id="wrapper">
        <div id="content">
          <?php while ($row = $values->fetch()): ?>
            <div class="post">
              <?php include 'votes.php'; ?>
                <div class="imagepost"><img src="img-posts/<?= $row['thumbnail'] ?>" alt="Post" class="align"></div>
                <div class="flexdiv">
                  <div class="postheader"><h5><a href="post.php?id=<?= $row['id'] ?>"><?= $row['title'] ?></a></h5></div>
                  <div class="submitted"><p>Submitted by: <a href="userindex.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a> to <a href="subindex.php?subbreddit=<?= $row['subbreddit'] ?>">b/<?= $row['subbreddit'] ?></a></p></div>
                  <div class="comments"><p><a href="commentindex.php?subbreddit=<?= $row['subbreddit'] ?>&postid=<?= $row['id'] ?>">comments</a> <a href="#">save</a> <a href="#">share</a> <a href="#">give award</a> <a href="#">repost</a> 
                  <a href="#">crosspost</a> <?php if(isset($_SESSION)): ?><a href="#">delete<?php endif ?></a></p></div>
              </div>
            </div>
          <?php endwhile ?>
        </div>

        <?php include 'sidebar.php'; ?>
    </div>
    <?php include 'footer.php'; ?>
    <script type="text/javascript">
      document.getElementById("hideAll").style.display = "none"; 
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
