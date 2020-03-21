<?php
  session_start();
  include 'connect.php';

  $query = "SELECT id, name, moderator FROM subbreddit";
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
    <div id="wrapper">
        <div id="content">
        <?php include 'sidebar.php'; ?>
          <form action="utility/process_post.php" method="post" class="createform" enctype="multipart/form-data">
            <input type="hidden" name="action" value="submit" />
            <fieldset class="createpost">
              <div class="create">
                <?php if(isset($_GET['link'])): ?>
                  <p>
                    <label for="title">Title</label>
                    <input class="createinput" name="title" id="title" />
                  </p>
                  <p>
                    <label id="subbredditdrop" for="subbreddit">Subbreddit</label>
                    <select id="dropdown" name="subbreddit">
                      <?php while ($row = $values->fetch()): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                      <?php endwhile ?>
                    </select>
                  </p>
                  <p>
                    <input class="createfile" type="file" name="image" accept="image/*">
                  </p>
                <?php elseif(isset($_GET['text'])): ?>
                  <p>
                    <label for="title">Title</label>
                    <input class="createinput" name="title" id="title" />
                  </p>
                  <p>
                    <label id="subbredditdrop" for="subbreddit">Subbreddit</label>
                    <select id="dropdown" name="subbreddit">
                      <?php while ($row = $values->fetch()): ?>
                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                      <?php endwhile ?>
                    </select>
                  </p>
                  <p>
                    <label for="content">Content</label>
                    <textarea name="content"></textarea>
                  </p>
                <?php else: ?>
                  <p>
                    <label for="title">Subbreddit Name</label>
                    <input class="createinput" name="subbredditname" id="title" />
                  </p>
                <?php endif ?>
              </div>
              <p>
                <input id="createbtn" type="submit" name="command" value="Create" />
              </p>
            </fieldset>
          </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
