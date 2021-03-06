<?php
    require 'utility/utility.php';
    session_start();
    
    if (filter_var($_GET['id'], FILTER_VALIDATE_INT)) 
    {
      $id = $_GET['id'];
    }
    else
    {
      header('Location: index.php');
    }

    $_SESSION['redirect_url'] = "post_page.php?id=$id";
    
    if(isset($_SESSION['user']))
    {
      $logUser = $_SESSION['user']['id'];
      $loggedUsername = $_SESSION['user']['name'];
    }

    $query = "SELECT c.id, c.title, c.post, c.votes, c.downvotes, c.userid, c.subbredditid, c.posttype, c.imagename, u.username, s.name
    FROM content c JOIN subbreddit s ON s.id = c.subbredditid  JOIN users u ON c.userid = u.id WHERE c.id = :id";
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
    <script src="utility/js/commentscript.js?98"></script>
    <title>breddit</title>
  </head>
  <body>
    <?php include 'header.php'; ?>
    <div id="wrapper">
      <div id="content">
        <?php include 'sidebar.php'; ?>
        <?php while ($row = $values->fetch()): ?>
            <div class="post">
              <?php include 'utility/votes.php'; ?>
              
                <div class="flexdiv">
                  <div class="postheader"><h5><?= $row['title'] ?></h5></div>

                  <div class="submitted">
                    <p>
                      Submitted by: <a href="user_index.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a>
                      to <a href="sub_index.php?subbreddit=<?= $row['name'] ?>">b/<?= $row['name'] ?></a>
                    </p>
                    </div>
                  
                  <div class="comments">
                    <p>
                      <a href="javascript:">save</a> 
                      <a href="javascript:">share</a> 
                      <a href="javascript:">give award</a> 
                      <a href="javascript:">repost</a> 
                      <a href="javascript:">crosspost</a> 
                      <?php if($mod == "Moderator"): ?><a href="javascript:">delete</a><?php endif ?>
                    </p>
                  </div>
                  
                  <?php if($row['posttype'] == 'l'): ?>
                    <div class="postcontent">
                      <img src="<?= $row['imagename'] ?>" alt="Post">
                    </div>
                  <?php endif ?>

                  <?php if($row['posttype'] == 't'): ?>
                    <div class="postcontent">
                      <p><?= $row['post'] ?></p>
                    </div>
                  <?php endif ?>
              </div>
            </div>
        <?php endwhile ?>

        <input type="hidden" name="action" value="submit" />
        <fieldset class="commentpost">
          <div class="create">
          <?php if(isset($_SESSION['user'])): ?>
              <p>
                <textarea id="commentfield" name="content" placeholder="Comment here"></textarea>
              </p>
          </div>
          <p>
            <input type="button" id="commentbtn" class=".btn-xs" value="Comment" onClick="CreateComment(<?= $id ?>, <?= $logUser ?>, '<?= $loggedUsername ?>');" />
          </p>
          <?php else: ?>
            <p>
              <textarea name="content" placeholder="Please sign in to comment"></textarea>
            </p>
          <?php endif ?>
        </fieldset>

        <?php while ($row = $statement->fetch()): ?>
          <div class="comment">
            <div class="votes">
                <a href="javascript:" class="fa fa-caret-up" style="font-size:25px"></a>
                <a href="javascript:" class="fa fa-caret-down" style="font-size:25px"></a>
            </div>
            <div class="flexdiv">
              <div class="submitted"><p><a href="user_index.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a> <?= $row['votes'] ?> points</p></div>
              <div class="postheader"><p><?= $row['content'] ?></p></div>
              <div class="comments">
              <p>
                <a href="javascript:">permalink</a> 
                <a href="javascript:">embed</a>
                <a href="javascript:">save</a> 
                <a href="javascript:">save-RES</a> 
                <a href="javascript:">report</a> 
                <a href="javascript:">reply</a>
                <?php if($mod == "Moderator"): ?>
                  <a href="process_postPage.php?deletecomment=1&commentid=<?= $row['id'] ?>">delete</a>
                <?php endif ?>
              </p>
              </div>
            </div>
          </div>
        <?php endwhile ?>
      </div>
    </div>
    <?php include 'footer.php'; ?>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>