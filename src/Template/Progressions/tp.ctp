<?php $this->assign('title', "Tp en fonction du temps"); ?>
<?php echo $this->Form->input('progression_id', [
    'label' => 'Filtrer par Progression:',
    'onchange' => 'select_progression()',
    'options' => $progressions,
    'default' => $progression_id
]); ?>
<span class="badge"><?php echo $nbTpTotal;  ?> TP</span>
<?php foreach ($listPeriodes as $periode): ?>

            <h2>
                <div class="alert alert-info" role="alert">
                    <strong><?php echo "Période n°" .h($periode->numero) ?></strong>
                    <span class="badge"><?php echo count($periode->rotations);  ?> Rotations</span>
                    <?php //debug($periode) ?>
                    <span class="badge"><?php echo $periode->tpByPeriode;  ?> TP</span>
                </div>
            </h2>


        <div class="well">
            <?php foreach ($periode->rotations as $rotation): ?>

                        <h4>
                            <span class="label label-primary">
                                <?php echo $rotation->fullName; ?>
                            </span>
                            <span class="badge"><?php echo $rotation->tpByRotation;  ?> TP </span>
                        </h4>


                        <table class = "table table-bordered" style = "background-color:#<?php echo $rotation->theme->color ?>;">
                            <tr>
                                <?php foreach ($rotation->travaux_pratiques as $tp): ?>
                                    <?php if ($tp->specifique == false): ?>
                                    <td><?php echo $this->Html->link($tp->nom,[
                                                'controller' => 'TravauxPratiques',
                                                'action' => 'edit',
                                                $tp->id
                                            ]);?></td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        </table>

            <?php endforeach; ?>
        </div>

<?php endforeach; ?>

<script>
function select_progression()
{
    var id = document.getElementById("progression-id").value;
    var url = "<?php echo $this->Url->build(['controller'=>'Progressions','action'=>'tp']) ?>" + "/?progression_id=" + id
	window.location = url;
}
</script>
