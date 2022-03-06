<?php $this->assign('title', "Tp en fonction du temps"); ?>
<?php foreach ($listPeriodes as $periode): ?>
    <details>
        <summary>
            <h2>
                <div class="alert alert-info" role="alert">
                    <strong><?php echo "Période n°" .h($periode->numero) ?></strong>
                    <span class="badge"><?php echo count($periode->rotations);  ?> Rotations</span>
                </div>
            </h2>

        </summary>
        <div class="well">
            <?php foreach ($periode->rotations as $rotation): ?>
                <details>
                    <summary>
                        <h4>
                            <span class="label label-primary">
                                <?php echo "P". h($periode->numero).
                                    "-". "R".
                                    h($rotation->numero) .": "
                                    .h($rotation->nom)
                                ?>
                            </span>
                            <span class="badge"><?php echo count($rotation->travaux_pratiques);  ?> TP </span>
                        </h4>

                    </summary>
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
                </details>
            <?php endforeach; ?>
        </div>
    </details>
<?php endforeach; ?>
