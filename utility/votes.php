<div class="votes">
    <?php if(isset($_SESSION['user'])): ?>
        <a href="javascript:" class="fa fa-caret-up" id="uv<?= $row['id'] ?>" style="font-size:25px" onClick="UpdateRecord(<?= $row['id'] ?>, 1);"></a>
        <p class="numvotes" id="<?= $row['id'] ?>"><?= thousandsFormat($row['votes']) ?></p>
        <a href="javascript:" class="fa fa-caret-down" id="dv<?= $row['id'] ?>" style="font-size:25px" onClick="UpdateRecord(<?= $row['id'] ?>, 2);"></a>
    <?php else: ?>
        <a data-toggle="tooltip" title="Must be signed in to vote" class="fa fa-caret-up" id="uv<?= $row['id'] ?>" style="font-size:25px"></a>
        <p class="numvotes" id="<?= $row['id'] ?>"><?= thousandsFormat($row['votes']) ?></p>
        <a data-toggle="tooltip" title="Must be signed in to vote" class="fa fa-caret-down" id="dv<?= $row['id'] ?>" style="font-size:25px"></a>
    <?php endif ?>
</div>