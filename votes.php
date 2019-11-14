<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="votescript.js"></script>

<div class="votes">
    <?php if(isset($_SESSION['user'])): ?>
        <a href="javascript:" class="fa fa-caret-up" id="uv<?= $row['id'] ?>" style="font-size:25px" onClick="UpdateRecord(<?= $row['id'] ?>, 1);"></a>
        <p class="numvotes" id="<?= $row['id'] ?>"><?= thousandsFormat($row['votes']) ?></p>
        <a href="javascript:" class="fa fa-caret-down" id="dv<?= $row['id'] ?>" style="font-size:25px" onClick="UpdateRecord(<?= $row['id'] ?>, 2);"></a>
    <?php else: ?>
        <a class="fa fa-caret-up" id="uv<?= $row['id'] ?>" style="font-size:25px"></a>
        <p id="<?= $row['id'] ?>" class="numvotes"><?= thousandsFormat($row['votes']) ?></p>
        <a class="fa fa-caret-down" id="dv<?= $row['id'] ?>" style="font-size:25px"></a>
    <?php endif ?>
</div>