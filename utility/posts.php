<?php
    $mod = $_SESSION['user']['mod'];
?>
<div class="post">
    <?php include 'votes.php'; ?>

    <div class="imagepost">
        <a href="img-posts/<?= $row['imagename'] ?>">
        <img src="img-posts/<?= $row['thumbnail'] ?>" alt="Post" class="align">
        </a>
    </div>

    <div class="flexdiv">
        <div class="postheader">
            <h5>
                <a href="post_page.php?id=<?= $row['id'] ?>">
                <?= $row['title'] ?>
                </a>
            </h5>
        </div>

        <div class="submitted">
            <p>
                Submitted 6 hours ago by: <a href="userindex.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a> to 
                <a href="subindex.php?subbreddit=<?= $row['name'] ?>">b/<?= $row['name'] ?></a>
            </p>
        </div>

        <div class="comments">
            <p>
                <a href="post_page.php?subbreddit=<?= $row['name'] ?>&id=<?= $row['id'] ?>">comments</a> 
                <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">save</a> 
                <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">share</a> 
                <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">give award</a>
                <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">repost</a> 
                <a href="javascript:" data-toggle="tooltip" title="Not Implemented Yet">crosspost</a> 
                <?php if($mod == 'Moderator'): ?>
                    <a href="process_postPage.php?delete=1&postid=<?= $row['id'] ?>">delete</a>
                <?php endif ?>
            </p>
        </div>

        <?php if($row['posttype'] == 'l'): ?>
            <div class="fullimagepost">
                <a href="img-posts/<?= $row['imagename'] ?>">
                    <img src="img-posts/<?= $row['imagename'] ?>" alt="Post" class="align">
                </a>
            </div>
        <?php else: ?>
            <div class="fulltextpost">
                <div class="textpostcontent">
                    <p><?= $row['post'] ?></p>
                </div>
            </div>
        <?php endif ?>

        <div class="mobilenav">
            <div><a class="fas fa-arrow-up" href="javascript:" id="uv<?= $row['id'] ?>" onClick="UpdateRecord(<?= $row['id'] ?>, 1);"></a></div>
            <div><a class="fas fa-arrow-down" href="javascript:" id="dv<?= $row['id'] ?>" onClick="UpdateRecord(<?= $row['id'] ?>, 2);"></a></div>
            <?php if($mod == 'Moderator'): ?>
                <div><a class="fas fa-times" href="process_postPage.php?delete=1&postid=<?= $row['id'] ?>"></a></div>
            <?php endif ?>
            <div><a class="fas fa-meteor" href="javascript:"></a></div>
            <div><a class="fas fa-share" href="javascript:"></a></div>
            <div><a class="fas fa-ellipsis-v" href="javascript:"></a></div>
        </div>

    </div>
</div>