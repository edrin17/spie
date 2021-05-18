<?php
$this->extend('/Common/tableauClasseur');
?>
<br>
<table class = 'table table-bordered table-hover'>
    <thead>
        <tr>
        <?php foreach($tableHeader as $key => $nom): ?>
            <th><?= $nom ?></th>
        <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tableau as $ligne): ?>
        <tr>
            <?php for ($i = 0; $i <= $nbColonnes; $i++): ?>
                <td style='background-color:<?= $ligne[$i]['contenu']['bgcolor'] ?>' >
                    <?= $ligne[$i]['nom'] ?>
                </td>
            <?php endfor ?>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

