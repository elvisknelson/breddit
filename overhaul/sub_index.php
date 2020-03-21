<?php
    require 'utility/utility.php';
    session_start();

    $subbreddit = filter_input(INPUT_GET, 'subbreddit', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT c.id, c.title, c.post, c.votes, c.userid, c.subbredditid, c.thumbnail, c.imagename, c.posttype, u.username, s.name
              FROM content c JOIN subbreddit s ON s.id = c.subbredditid JOIN users u ON c.userid = u.id WHERE s.name = :subbreddit";
    $values = $db->prepare($query);
    $values->bindValue(':subbreddit', $subbreddit);
    $values->execute();
?>

<!doctype html>
<html lang="en">
  <?php include 'head.php' ?>
  <body>
    <div style="display: none" id="hideAll">&nbsp;</div>
    <script type="text/javascript">
      document.getElementById("hideAll").style.display = "block";
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
      <a id="load">Load More</a>
    </div>
    <?php include 'footer.php'; ?>
    <script type="text/javascript">
      document.getElementById("hideAll").style.display = "none"; 
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
