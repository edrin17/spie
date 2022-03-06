<?php $this->assign('title', 'Association Objectifs Pédas et T.P');
if ($spe) {
    $html['spe'] = 0;
    $html['label'] = 'Voir les TP normaux';
    $html['color'] = 'btn-success';
}else {
    $html['spe'] = 1;
    $html['label'] = 'Voir les TP spécifiques';
    $html['color'] = 'btn-warning';
}
?>
<div class="row">
    <div class="col-md-8">
        <?php echo $this->Html->link($html['label'],
            ['action' => 'view',1,
                '?' => [
                    //'LVL1' => $selectedLVL1,
                    //'LVL2' => $selectedLVL2->id,
                    'spe' => $html['spe'],
                    //'options' => $options,
                ]
            ],['class' => "btn ".$html['color'],'role' => 'button' ]); ?>
    </div>
</div>

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
