<?php
  require 'utility/connect.php';
  session_start();
?>

<!doctype html>
<html lang="en">
  <?php include 'head.php' ?>
  <body>
    <?php include 'header.php'; ?>
    <div id="wrapper">
        <div id="content">
        <?php include 'sidebar.php'; ?>
          <form action="utility/process_post.php" method="post" class="createuserform" enctype="multipart/form-data">
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
    </div>
    <?php include 'footer.php'; ?>

    <script src="utility/js/script.js"></script>
  </body>
</html>
