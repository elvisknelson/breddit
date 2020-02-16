<div class="votes">
    <?php if(isset($_SESSION['user'])): ?>
        <div id="row"><h1><?= $_SESSION['postCount'] += 1 ?></h1></div>
        <div id="voteDiv">
            <a href="javascript:" class="fa fa-caret-up" id="uv<?= $row['id'] ?>" style="font-size:25px" onClick="addVote(<?= $row['id'] ?>, 1);"></a>
            <p class="numvotes" id="<?= $row['id'] ?>"><?= thousandsFormat($row['votes']) ?></p>
            <a href="javascript:" class="fa fa-caret-down" id="dv<?= $row['id'] ?>" style="font-size:25px" onClick="addVote(<?= $row['id'] ?>, 2);"></a>
        </div>
    <?php else: ?>
        <div id="row"><h1><?= $_SESSION['postCount'] += 1 ?></h1></div>
        <div id="voteDiv">
            <a data-toggle="tooltip" title="Must be signed in to vote" class="fa fa-caret-up" id="uv<?= $row['id'] ?>" style="font-size:25px"></a>
            <p class="numvotes" id="<?= $row['id'] ?>"><?= thousandsFormat($row['votes']) ?></p>
            <a data-toggle="tooltip" title="Must be signed in to vote" class="fa fa-caret-down" id="dv<?= $row['id'] ?>" style="font-size:25px"></a>
        </div>
    <?php endif ?>
</div>