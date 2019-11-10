<?php
  require 'connect.php';
  require 'utility.php';
  session_start();

  if(isset($GET['sort']))
  {
    $var = $GET['sort'];

    switch ($var) {
      case 'new':
        $postsort = 'date';
        break;
      case 'hot':
        $postsort = 'votes';
        break;
      case 'best':
        $postsort = 'votes';
        break;
      case 'top':
        $postsort = 'votes';
        break;
    }
  }
  else
  {
    $postsort = 'date';
  }

  $query = "SELECT c.id, c.title, c.post, c.votes, c.downvotes, c.userid, c.subbreddit, c.imagename, c.thumbnail, c.posttype, u.username, u.id AS userid 
            FROM content c JOIN users u ON c.userid = u.id order by $postsort desc";

  $values = $db->prepare($query);
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
    <?php include 'header.php'; ?>
    
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    
    <div id="wrapper">
        <div id="content">
          <?php while ($row = $values->fetch()): ?>
            <div class="post">

              <div class="votes">
                <a href="process_post.php?vote=1&postid=<?= $row['id'] ?>" class="fa fa-caret-up" style="font-size:25px"></a>
                <p class="numvotes"><?= thousandsFormat($row['votes']) ?></p>
                <a href="process_post.php?vote=2&postid=<?= $row['id'] ?>" class="fa fa-caret-down" style="font-size:25px"></a>
              </div>

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
                  <p>Submitted by: <a href="userindex.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a> to <a href="subindex.php?subbreddit=<?= $row['subbreddit'] ?>">b/<?= $row['subbreddit'] ?></a></p>
                </div>

                <div class="comments">
                  <p>
                    <a href="commentindex.php?subbreddit=<?= $row['subbreddit'] ?>&id=<?= $row['id'] ?>">comments</a> <a href="">save</a> <a href="">share</a> <a href="">give award</a> <a href="">repost</a> 
                    <a href="">crosspost</a> <?php if($mod == 'Moderator'): ?><a href="process_post.php?delete=1&postid=<?= $row['id'] ?>">delete<?php endif ?></a>
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
                  <div><a class="fas fa-arrow-up" href=""></a></div>
                  <div><a class="fas fa-arrow-down" href=""></a></div>
                  <div><a class="fas fa-times" href=""></a></div>
                  <div><a class="fas fa-meteor" href=""></a></div>
                  <div><a class="fas fa-share" href=""></a></div>
                  <div><a class="fas fa-ellipsis-v" href=""></a></div>
                </div>

              </div>
              
            </div>
          <?php endwhile ?>
        </div>
        <?php include 'sidebar.php'; ?>
    </div>
    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
