<div id="sidebar">
    <form action="index.php" method="post" class="searchform">
        <fieldset>
            <input type="hidden" name="action" value="submit" />
            <div class="search">
                <input class="searchfield" type="text" placeholder="Search.." name="search">
                <button class="fa fa-search searchbtn" type="submit" name="command" value="Search"></button>
            </div>
        </fieldset>
    </form>
    <form action="utility/process_post.php" method="post" class="loginform">
        <input type="hidden" name="action" value="submit" />
        <fieldset class="login">
            <?php if(!isset($_SESSION['user'])): ?>
                <div class="logininput">
                    <input name="name" type="text" id="loginuser" placeholder="username"/>
                    <input name="password" type="password" id="loginpassword" placeholder="password"/>
                </div>
                <a class="btn btn-default btn-sm btn-square loginbtn" href="new_user.php">Sign Up</a>
                <button class="btn btn-default btn-sm btn-square loginbtn" type="submit" name="command" value="Login">Login</button>
            <?php else: ?>
                <button class="btn btn-default btn-sm btn-square loginbtn" id="logoutbtn" type="submit" name="command" value="Logout">Logout</button>
            <?php endif ?>
        </fieldset>
    </form>
    <?php if(isset($_SESSION['user'])): ?>
        <div class="submitlink"><a href="create.php?link=1"><p>Submit a new link</p></a></div>
        <div class="submitlink"><a href="create.php?text=1"><p>Submit a new text post</p></a></div>
        <div class="submitlink"><a href="create.php?sub=1"><p>Create a New Subbreddit</p></a></div>
    <?php endif ?>
    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="images/bredditad.png" alt="Img"></a>
</div>

