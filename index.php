<?php
  session_start();
  $_SESSION['redirect_url'] = $_SERVER['PHP_SELF']; 
  $_SESSION['page'] = 1;

  if(isset($_GET['sort'])) {
    $var = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    switch ($var) {
      case 'new':
        $postsort = 'date';
        break;
      case 'hot':
        $postsort = 'votes';
        break;
      case 'best':
        $postsort = 'votes';
        break;
      case 'top':
        $postsort = 'votes';
        break;
    }
  }
  else {
    $postsort = 'date';
  }
?>

<!doctype html>
<html lang="en">
  <?php include 'head.php' ?>
  <body>
    <div style="display: none" id="hideAll">&nbsp;</div>
    <script type="text/javascript">
      document.getElementById("hideAll").style.display = "none";
    </script>
    <?php include 'header.php'; ?>
    
    <div id="wrapper">
        <div id="content">
          <?php include 'sidebar.php'; ?>
          <div id='main'>
          </div>
        </div>
        
    </div>
    <div class="loadmore">
      <button onclick="loadPosts()" class="btn btn-link" type="submit" name="command" value="LoadMore">page: <?= $_SESSION['page'] ?> | load more</button>
    </div>
    <?php include 'footer.php'; ?>
    <script src="utility/js/loadPosts.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
      document.getElementById("hideAll").style.display = "none";
    </script>
  </body>
</html>