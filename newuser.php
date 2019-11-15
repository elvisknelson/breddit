<?php
  require 'connect.php';
  session_start();
  if(isset($_POST['action']))
  {
    if($_POST['command'] == 'Create_User')
    {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        // if($username == 'elfishpro' || $username == 'admin' || $username == 'namename')
        // {
        //     $ismod = true;
        // }
        // else
        // {
        //     $ismod = false;
        // }
        $ismod = true;
        $insertQuery = "INSERT INTO users (username, password, moderator) VALUES (:uname, :upassword, :moderator)";
        $statement = $db->prepare($insertQuery);
        $statement->bindValue(':uname', $username);
        $statement->bindValue(':upassword', password_hash($password2, PASSWORD_BCRYPT));
        $statement->bindValue(':moderator', $ismod);
        $statement->execute();

        // $query = "SELECT id FROM users WHERE username = (:user)";
        // $values = $db->prepare($query);
        // $values->bindValue(':user', $username);
        // $values->execute();
        // $row = $values->fetch();
        // $_SESSION['user'] = [ 'name' => $username, 'id' => $,'mod' => true ];

        header('Location: index.php');
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
          <form action="" method="post" class="createuserform" enctype="multipart/form-data">
            <input type="hidden" name="action" value="submit" />
            <fieldset class="createuser">
              <div class="create">
                <p>
                  <label for="username">Username</label>
                  <input class="createinput" name="username" id="newusername" />
                </p>
                <p>
                  <label for="password1">Password</label>
                  <input class="createinput" name="password1" type="password" id="newpassword1" />
                </p>
                <p>
                  <label for="password2">Re-Enter Password</label>
                  <input class="createinput" name="password2" type="password" id="newpassword2" />
                </p>
              </div>
              <p>
                <button type="submit" name="command" value="Create_User" id="createnewuser">Create</button>
              </p>
              <p>
                <p class="text-center text-danger" id="errormessage"></p>
              </p>
            </fieldset>
          </form>
        </div>
      <?php include 'sidebar.php'; ?>
    </div>
    <?php include 'footer.php'; ?>

    <script src="script.js"></script>
  </body>
</html>
