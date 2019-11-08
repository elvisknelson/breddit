<?php
    require 'connect.php';
    require 'utility.php';
    session_start();

    $id = $_GET['id'];
    
    if(isset($_SESSION['user']))
    {
      $logUser = $_SESSION['user']['id'];
    }

    $query = "SELECT c.id, c.title, c.post, c.votes, c.downvotes, c.userid, c.subbreddit, c.posttype, c.imagename, u.username FROM content c JOIN users u ON c.userid = u.id WHERE c.id = :id";
    $values = $db->prepare($query);
    $values->bindValue(':id', $id);
    $values->execute();

    $query = "SELECT c.id, c.content, c.userid, c.votes, c.postid, u.username FROM comments c JOIN users u ON u.id = c.userid WHERE postid = :postID";
    $statement = $db->prepare($query);
    $statement->bindValue(':postID', $id);
    $statement->execute();
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
    <div id="wrapper">
        <div id="content">
            <?php while ($row = $values->fetch()): ?>
                <div class="post">
                    <div class="votes">
                      <a href="process_post.php?vote=1&postid=<?= $row['id'] ?>" class="fa fa-caret-up" style="font-size:25px"></a>
                      <p class="numvotes"><?= thousandsFormat($row['votes'] - $row['downvotes']) ?></p>
                      <a href="process_post.php?vote=2&postid=<?= $row['id'] ?>" class="fa fa-caret-down" style="font-size:25px"></a>
                    </div>
                    <div class="flexdiv">
                      <div class="postheader"><h5><?= $row['title'] ?></h5></div>
                      <div class="submitted"><p>Submitted by: <a href="userindex.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a> to <a href="subindex.php?subbreddit=<?= $row['subbreddit'] ?>">b/<?= $row['subbreddit'] ?></a></p></div>
                      <div class="comments"><p><a href="">save</a> <a href="">share</a> <a href="">give award</a> <a href="">repost</a> <a href="">crosspost <?php if(isset($_SESSION)): ?><a href="">delete<?php endif ?></a></p></div>
                      <?php if($row['posttype'] == 'l'): ?>
                      <div class="postcontent"><img src="img-posts/<?= $row['imagename'] ?>" alt="Post"></div>
                      <?php endif ?>
                      <?php if($row['posttype'] == 't'): ?>
                        <div class="postcontent"><p><?= htmlspecialchars_decode($row['post'], ENT_QUOTES) ?></p></div>
                      <?php endif ?>
                  </div>
                </div>
            <?php endwhile ?>

            <form action="process_post.php?postid=<?= $id ?>&user=<?= $logUser ?>" method="post" enctype="multipart/form-data">
              <input type="hidden" name="action" value="submit" />
              <fieldset class="commentpost">
                <div class="create">
                    <p>
                      <textarea name="content" placeholder="Comment here"></textarea>
                    </p>
                </div>
                <p>
                <input class=".btn-xs" type="submit" name="command" value="Comment" />
                <input class=".btn-xs" type="reset" name="command"/>
                </p>
              </fieldset>
            </form>

            <?php while ($row = $statement->fetch()): ?>
            <div class="comment">
              <div class="votes">
                  <a href="" class="fa fa-caret-up" style="font-size:25px"></a>
                  <a href="" class="fa fa-caret-down" style="font-size:25px"></a>
              </div>
              <div class="flexdiv">
                <div class="submitted"><p><a href="userindex.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a> <?= $row['votes'] ?> points</p></div>
                <div class="postheader"><p><?= $row['content'] ?></p></div>
                <div class="comments"><p><a href="">permalink</a> <a href="">embed</a> <a href="">save</a> <a href="">report</a> <a href="">reply</a></div>
                <div id="newcomment">
                  <form action="process_post.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="submit" />
                    <fieldset class="commentpost">
                      <div class="create">
                          <p>
                            <textarea name="content"></textarea>
                          </p>
                      </div>
                      <p>
                      <input class="btn-sm" type="submit" name="command" value="Comment" />
                      <input class="btn-sm" type="reset" name="command"/>
                      </p>
                    </fieldset>
                  </form>
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