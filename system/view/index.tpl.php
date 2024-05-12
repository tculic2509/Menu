<h1>Meni</h1>
<h2>Resursi:</h2>
<?php
foreach ($data['resursi'] as $key => $_data) { ?>
    <strong>
        http://localhost/Meni/?page=<?= $_data['url'] ?>
    </strong>
    <br>
    <?= $_data['description'] ?><br>
    <?= $_data['method'] ?><br>
    -------------------------------------------------
    <br><br>
<?php } ?>

______________________________________________________________
<h2>Jela:</h2>
<?php
foreach ($data['meals'] as $key => $_data) { ?>
    <strong>
        <?= 'Naziv jela: ' . $_data['title'] . '<br>' ?>
        <?= 'Opis jela: ' . $_data['description'] . '<br>' ?>
    </strong>
    <br><br>
<?php } ?>
