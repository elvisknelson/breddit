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