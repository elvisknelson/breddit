<?php
    $user = null;
    $mod = null;

    if(!empty($_SESSION))
    {
        $user = $_SESSION['user']['name'];
        $mod = $_SESSION['user']['mod'] ? 'Moderator' : 'User';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>breddit</title>
</head>
<body>
    <!-- Sign In Form -->
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Sign in</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="process_post.php" method="post">
                <input type="hidden" name="action" value="submit" />
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <input name="name" type="text" id="defaultForm-user" class="form-control validate" placeholder="username">
                    </div>
                    
                    <div class="md-form mb-4">
                        <input name="password" type="password" id="defaultForm-pass" class="form-control validate" placeholder="password">
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-info" name="command" value="Login">Login</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <!-- Sign Up Form -->
    <div class="modal fade" id="modalSignupForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Sign Up</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="process_post.php" method="post">
                <input type="hidden" name="action" value="submit" />
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <input name="username" type="text" id="defaultForm-user" class="form-control validate" placeholder="username">
                    </div>
                    
                    <div class="md-form mb-4">
                        <input name="password1" type="password" id="defaultForm-pass" class="form-control validate" placeholder="password">
                    </div>

                    <div class="md-form mb-4">
                        <input name="password2" type="password" id="defaultForm-pass" class="form-control validate" placeholder="confirm password">
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-info" name="command" value="Create_User">Sign Up</button>
                </div>
            </form>
        </div>
      </div>
    </div>

    <!-- Hamburger Nav -->
    <nav id="hamburgernav" class="navbar navbar-light light-blue lighten-4">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent15"
        aria-controls="navbarSupportedContent15" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <p class="mobileheader">breddit: the back alley of the internet</p>

        <div class="collapse navbar-collapse" id="navbarSupportedContent15">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>

                <?php if($user == null): ?>
                    <li class="nav-item">
                    <a href="" class="nav-link" data-toggle="modal" data-target="#modalLoginForm">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link" data-toggle="modal" data-target="#modalSignupForm">Sign Up</a>
                    </li>
                <?php else: ?>
                    <form action="process_post.php" method="post">
                        <input type="hidden" name="action" value="submit" />
                        <li class="nav-item">
                            <a class="nav-link" href="create.php?link=1">Submit Link</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="create.php?text=1">Submit Text</a>
                        </li>
                        <li class="nav-item">
                            <button class="btn btn-link nav-link bold" name="command" value="Logout">Logout (<?= $_SESSION['user']['name'] ?>)</button>
                        </li>
                    </form>
                <?php endif ?>
            </ul>
        </div>
    </nav>

    <div id="header">
        <div class="flex">
            <a href="index.php"><img src="images/snoo.png" alt="Logo" class="logo"></a>
            <a href="index.php"><h1>breddit</h1></a>
            <ul id="menu">
                <a href="index.php" class="active"><li>new</li></a>
                <a href="index.php" class=""><li>hot</li></a>
                <a href="index.php" class=""><li>best</li></a>
                <a href="index.php" class=""><li>rising</li></a>
                <a href="index.php" class=""><li>controversial</li></a>
                <a href="index.php" class=""><li>top</li></a>
                <a href="index.php" class=""><li>gilded</li></a>
            </ul>
        </div>
        <?php if($user == null): ?>
            <div class="loginheader">
                <p>Want to join? <a href="javascript:focus()">Log in</a> or <a href="newuser.php">sign up</a> in seconds. <a href="#">|English|</a></p>
            </div>
        <?php else: ?>
            <div class="loginheader">
                <p><?= $user ?> | <a href="index.php"><img src="images/snoo.png" alt="Logo"></a> | <?= $mod ?></a></p>
            </div>
        <?php endif ?>
    </div>
    <script src="focus.js"></script>
</body>
</html>
