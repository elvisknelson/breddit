<?php
    require 'connect.php';
    require 'utility.php';
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
        <?php while ($row = $values->fetch()): ?>
          <div class="post">

            <?php include 'votes.php'; ?>

            <div class="imagepost">
              <a href="img-posts/<?= $row['imagename'] ?>">
                <img src="img-posts/<?= $row['thumbnail'] ?>" alt="Post" class="align">
              </a>
            </div>
            
            <div class="flexdiv">

              <div class="postheader">
                <h5>
                  <a href="post.php?id=<?= $row['id'] ?>">
                    <?= $row['title'] ?>
                  </a>
                </h5>
              </div>

              <div class="submitted">
                <p>
                  Submitted by: <a href="userindex.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a> to 
                  <a href="subindex.php?subbreddit=<?= $row['subbreddit'] ?>">b/<?= $row['name'] ?></a>
                </p>
              </div>

              <div class="comments">
                <p>
                  <a href="post.php?subbreddit=<?= $row['name'] ?>&id=<?= $row['id'] ?>">comments</a> 
                  <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">save</a> 
                  <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">share</a> 
                  <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">give award</a>
                  <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">repost</a> 
                  <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">crosspost</a> 
                  <?php if($mod == 'Moderator'): ?>
                    <a href="process_post.php?delete=1&postid=<?= $row['id'] ?>">delete</a>
                  <?php endif ?>
                </p>
              </div>

              <?php if($row['posttype'] == 'l'): ?>
                <div class="fullimagepost">
                  <a href="img-posts/<?= $row['imagename'] ?>">
                    <img src="img-posts/<?= $row['imagename'] ?>" alt="Post" class="align">
                  </a>
                </div>
              <?php else: ?>
                <div class="fulltextpost">
                  <div class="textpostcontent"><p><?= $row['post'] ?></p></div>
                </div>
              <?php endif ?>
              
              <div class="mobilenav">
                <div><a class="fas fa-arrow-up" href="javascript:" id="uv<?= $row['id'] ?>" onClick="UpdateRecord(<?= $row['id'] ?>, 1);"></a></div>
                <div><a class="fas fa-arrow-down" href="javascript:" id="dv<?= $row['id'] ?>" onClick="UpdateRecord(<?= $row['id'] ?>, 2);"></a></div>
                <?php if($mod == 'Moderator'): ?>
                  <div><a class="fas fa-times" href="process_post.php?delete=1&postid=<?= $row['id'] ?>"></a></div>
                <?php endif ?>
                <div><a class="fas fa-meteor" href="javascript:"></a></div>
                <div><a class="fas fa-share" href="javascript:"></a></div>
                <div><a class="fas fa-ellipsis-v" href="javascript:"></a></div>
              </div>

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
