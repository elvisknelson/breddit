<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
    <div id="sidebar">
        <form action="process_post.php" method="post" class="loginform">
            <input type="hidden" name="action" value="submit" />
            <fieldset class="login">
                <?php if(isset($_GET['invaliduser'])): ?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <strong>Invalid username and password</strong>
                    </div>
                <?php endif ?>
                <?php if(!isset($_SESSION['user'])): ?>
                    <div class="logininput">
                        <input name="name" type="text" id="title" placeholder="username"/>
                        <input name="password" type="password" id="title" placeholder="password"/>
                    </div>
                    <a class="btn btn-default btn-sm btn-square loginbtn" href="newuser.php">Sign Up</a>
                    <input class="btn btn-default btn-sm btn-square loginbtn" type="submit" name="command" value="Login" />
                <?php else: ?>
                    <input class="btn btn-default btn-sm btn-square loginbtn" type="submit" name="command" value="Logout" />
                <?php endif ?>
            </fieldset>
        </form>
        <div class="submitlink"><a href="create.php?link=1"><p>Submit a new link</p></a></div>
        <div class="submitlink"><a href="create.php?text=1"><p>Submit a new text post</p></a></div>
        <a href="https://www.reddit.com/premium"><img src="images/bredditad.png" alt="Img"></a>
    </div>
</body>
</html>