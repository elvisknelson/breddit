<?php
    $mod = isset($_SESSION['user']['mod']) ? "Moderator" : "";
?>
<div class="post">

    <?php include 'votes.php'; ?>

    <div class="imagepost">
        <a href="<?= $row['imagename'] ?>">
        <img src="<?= $row['thumbnail'] ?>" alt="Post" class="align">
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

        <div>
            <?php if($row['posttype'] == 'l'): ?>
                <a class="expandobtnlink" id="expandobtn<?= $row['id'] ?>" onclick="showExpando('expando<?= $row['id'] ?>', 'expandobtn<?= $row['id'] ?>')"></a>
            <?php else: ?>
                <a class="expandobtntext" id="expandobtn<?= $row['id'] ?>" onclick="showExpando('expando<?= $row['id'] ?>', 'expandobtn<?= $row['id'] ?>')"></a>
            <?php endif ?>
            
            <div class="submitted">
                <p>
                    Submitted 6 hours ago by: <a href="user_index.php?username=<?= $row['username'] ?>"><?= $row['username'] ?></a> to 
                    <a href="sub_index.php?subbreddit=<?= $row['name'] ?>">b/<?= $row['name'] ?></a>
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
                        <a href="utility/process_post.php?delete=1&postid=<?= $row['id'] ?>">delete</a>
                    <?php endif ?>
                </p>
            </div>
        </div>

        <?php if($row['posttype'] == 'l'): ?>
            <div class="fullimagepost">
                <a href="img-posts/<?= $row['imagename'] ?>">
                    <img src="<?= $row['imagename'] ?>" alt="Post" class="postthumb">
                </a>
            </div>
        <?php else: ?>
            <div class="fulltextpost">
                <div class="textpostcontent">
                    <p><?= $row['post'] ?></p>
                </div>
            </div>
        <?php endif ?>

        <!-- Expando Image -->
        <?php if($row['posttype'] == 'l'): ?>
            <img src="<?= $row['imagename'] ?>" draggable="false" id="expando<?= $row['id'] ?>" class="extendoimage" style="display: none" />
        <?php else: ?>
            <div id="expando<?= $row['id'] ?>" class="extendoimage" style="display: none">
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