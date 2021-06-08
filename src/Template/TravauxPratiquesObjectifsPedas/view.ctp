<?php $this->assign('title', 'Association Objectifs Pédas et T.P'); ?>  <!-- Customise le titre de la page -->
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
            <td rel="popover" data-toggle="popover" data-placement="left" data-container= "td" data-html="true" title= "<?= $ligne[$i]['contenu'] ?>">
                <?= $ligne[$i]['nom'] ?>
                <?= $ligne[$i]['nbTPs'] ?>
            </td>
            <?php endfor ?>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
//active l'uilisation de code html dans le tooltip
$("[rel=popover").popover({html:true});
</script>
