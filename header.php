<?php
    $user = null;
    $mod = null;
    $new = $hot = $best = $top = "";

    if(isset($_GET['sort']))
    {
        $sort = $_GET['sort'];
    } else
    {
        $sort = 'new';
    }

    switch ($sort) {
        case 'new':
            $new = "active";
            break;
        case 'hot':
            $hot = "active";
            break;
        case 'best':
            $best = "active";
            break;
        case 'top':
            $top = "active";
            break;
    }

    if(isset($_SESSION['user']))
    {
        $user = $_SESSION['user']['name'];
        $mod = $_SESSION['user']['mod'] ? 'Moderator' : 'User';
    }
?>

<!-- Sign In Form -->
<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div class="signupmodal">

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
                        <input name="name" type="text" id="signinusername" class="signup-form-control validate" placeholder="username">
                    </div>
                    
                    <div class="md-form mb-4">
                        <input name="password" type="password" id="defaultForm-pass" class="signup-form-control validate" placeholder="password">
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
<div class="modal fade" id="modalSignupForm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="signupmodal">
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
                    <input name="username" type="text" id="signupusername" class="signup-form-control validate" placeholder="username">
                </div>
                
                <div class="md-form mb-4">
                    <input name="password1" type="password" id="defaultForm-pass1" class="signup-form-control validate" placeholder="password">
                </div>

                <div class="md-form mb-4">
                    <input name="password2" type="password" id="defaultForm-pass2" class="signup-form-control validate" placeholder="confirm password">
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

    <button class="navbutton navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent15"
    aria-controls="navbarSupportedContent15" aria-expanded="false" aria-label="Toggle navigation"><i class="navbars fas fa-bars fa-1x"></i></button>
    <p class="mobileheader">breddit: the back alley of the internet</p>

    <div class="collapse navbar-collapse" id="navbarSupportedContent15">
        <form action="process_post.php" method="post">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link hamburgeritem" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>

                <?php if($user == null): ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link hamburgeritem" data-toggle="modal" data-target="#modalLoginForm">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link hamburgeritem" data-toggle="modal" data-target="#modalSignupForm">Sign Up</a>
                    </li>
                <?php else: ?>
                    <input type="hidden" name="action" value="submit" />
                    <li class="nav-item">
                        <a class="nav-link hamburgeritem" href="create.php?link=1">Submit Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-lin hamburgeritem" href="create.php?text=1">Submit Text</a>
                    </li>
                    <li class="nav-item">
                        <button class="btn btn-link nav-link bold" name="command" value="Logout">Logout (<?= $_SESSION['user']['name'] ?>)</button>
                    </li>
                <?php endif ?>
            </ul>
        </form>
    </div>
</nav>

<div id="header">
    <div class="flex">
        <a href="index.php"><img src="images/bredditsnoo.png" alt="Logo" class="logo"></a>
        <a href="index.php"><h1>breddit</h1></a>
        <ul id="menu">
            <li><a href="index.php?sort=new" class="<?= $new ?>">new</a></li>
            <li><a href="index.php?sort=hot" class="<?= $hot ?>">hot</a></li>
            <li><a data-toggle="tooltip" title="Not Implemented Yet" class="<?= $best ?>">best</a></li>
            <li><a data-toggle="tooltip" title="Not Implemented Yet" class="<?= $top ?>">top</a></li>
        </ul>
    </div>
    <?php if($user == null): ?>
        <div class="loginheader">
            <p>Want to join? <a href="javascript:focus()">Log in</a> or <a href="newuser.php">sign up</a> in seconds. <a href="#">|English|</a></p>
        </div>
    <?php else: ?>
        <div class="loginheader">
            <p><a data-toggle="tooltip" title="Not Implemented Yet" href="#"><?= $user ?></a> | <a href="index.php"><img src="images/bredditsnoo.png" alt="Logo"></a> | 
            <a data-toggle="tooltip" title="Not Implemented Yet" href="#"><?= $mod ?></a></p>
        </div>
    <?php endif ?>
</div>
<script src="focus.js"></script>
