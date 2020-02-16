<?php
  session_start();
  if(!isset($_SESSION['sort'])) {
    $_SESSION['sort'] = "c.date";
  }
  else {
    if(isset($_GET['sort']))
    {
      $_SESSION['sort'] = $_GET['sort'];
    }
  }
?>

<!doctype html>
<html lang="en">
  <?php include 'head.php' ?>
  <body>
    <div style="display: none" id="hideAll">&nbsp;</div>
    <script type="text/javascript">document.getElementById("hideAll").style.display = "none";</script>
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
  </body>
</html>