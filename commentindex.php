<?php
    require 'connect.php';
    require 'utility.php';
    session_start();

    $postid = $_GET['postid'];
    $subbreddit = $_GET['subbreddit'];
    
    $query = "SELECT c.id, c.title, c.post, c.votes, c.userid, c.subbreddit, c.imagename, c.posttype, u.username FROM content c JOIN users u ON c.userid = u.id WHERE c.id = :postID";
    $postStatement = $db->prepare($query);
    $postStatement->bindValue(':postID', $postid);
    $postStatement->execute();
    $post = $postStatement->fetch();

    $query = "SELECT c.id, c.content, c.userid, c.votes, c.postid, u.username FROM comments c JOIN users u ON u.id = c.userid WHERE postid = :postID";
    $values = $db->prepare($query);
    $values->bindValue(':postID', $postid);
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
    <div id="wrapper">
        <?php include 'header.php'; ?>

        <div id="content">
          <div class="post">
              <div class="votes">
                  <a href="" class="fa fa-caret-up" style="font-size:25px"></a>
                  <p class="numvotes"><?= thousandsFormat($post['votes']) ?></p>
                  <a href="" class="fa fa-caret-down" style="font-size:25px"></a>
              </div>
              <div class="flexdiv">
                <div class="postheader"><h5><a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h5></div>
                <div class="submitted"><p>Submitted by: <a href="userindex.php?username=<?= $post['username'] ?>"><?= $post['username'] ?></a> to <a href="subindex.php?subbreddit=<?= $post['subbreddit'] ?>">b/<?= $post['subbreddit'] ?></a></p></div>
                <div class="comments"><p><a href="commentindex.php?subbreddit=<?= $post['subbreddit'] ?>&postid=<?= $post['id'] ?>">comments</a> <a href="">save</a> <a href="">share</a> <a href="">give award</a> <a href="">repost</a> 
                <a href="">crosspost</a> <?php if(isset($_SESSION)): ?><a href="">delete<?php endif ?></a></p></div>
                <?php if($post['posttype'] == 'l'): ?>
                  <div class="postcontent"><img src="img-posts/<?= $post['imagename'] ?>" alt="Post"></div>
                <?php endif ?>
                <?php if($post['posttype'] == 't'): ?>
                  <div class="postcontent"><p><?= $post['post'] ?></p></div>
                <?php endif ?>
            </div>
          </div>

          <form action="process_post.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="submit" />
            <fieldset class="commentpost">
              <div class="create">
                  <p>
                    <textarea name="content"></textarea>
                  </p>
              </div>
              <p>
              <input class=".btn-xs" type="submit" name="command" value="Comment" />
              <input class=".btn-xs" type="reset" name="command"/>
              </p>
            </fieldset>
          </form>

          <?php while ($row = $values->fetch()): ?>
            <div class="comment">
              <div class="votes">
                  <a href="" class="fa fa-caret-up" style="font-size:25px"></a>
                  <a href="" class="fa fa-caret-down" style="font-size:25px"></a>
              </div>
              <div class="flexdiv">
                <div class="submitted"><p><a href="userindex.php?username=<?= $row['username'] ?>"><?= $post['username'] ?></a> <?= $row['votes'] ?> points</p></div>
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
    <script src="script.js"></script>
  </body>
</html>