<?php $this->assign('title', "Tp en fonction du temps"); ?>
<?php foreach ($listPeriodes as $periode): ?>
    <details>
        <summary>
            <h2>
                <div class="alert alert-info" role="alert">
                    <strong><?= "Période n°" .h($periode->numero) ?></strong>
                    <span class="badge"><?= count($periode->rotations);  ?> Rotations</span>
                </div>
            </h2>

        </summary>
        <div class="well">
            <?php foreach ($periode->rotations as $rotation): ?>
                <details>
                    <summary>
                        <h4>
                            <span class="label label-primary">
                                <?= "P". h($periode->numero).
                                    "-". "R". 
                                    h($rotation->numero) .": " 
                                    .h($rotation->nom)
                                ?>
                            </span>
                            <span class="badge"><?= count($rotation->travaux_pratiques);  ?> TP </span>
                            <i class="fa fa-user" aria-hidden="true" title="Responsable"></i>
                            <?= h($rotation->user->nom) ?>
                        </h4>
                        
                    </summary>
                        <table class = "table table-bordered" style = "background-color:#<?= $rotation->theme->color ?>;">
                            <tr>
                                <?php foreach ($rotation->travaux_pratiques as $tp): ?>
                                    <td data-toggle="modal" data-target="#myModal-<?= $tp->id ?>" class="text-center">
                                        <?= h($tp->nom)?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                </details>
            <?php endforeach; ?>
        </div>
    </details>
<?php endforeach; ?>

<?php foreach ($listPeriodes as $periode): ?>
    <?php foreach ($periode->rotations as $rotation): ?>
        <?php foreach ($rotation->travaux_pratiques as $tp): ?>
        <div class="modal fade bs-example-modal-lg" id="myModal-<?= $tp->id ?>" tabindex="-1" role="dialog" aria-labelledby="test">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <!-- bouton Fermer -->
                    <h4 class="modal-title" id="myModalLabel"><?= $tp->nom ?></h4>
                </div>
                <div class="modal-body">
                    <div id= "tableau">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button id= "button-<?= $tp->id ?>" type="submit" value="<?= $tp->id ?>" class="btn btn-primary" data-dismiss="modal">
                        Test
                    </button>
                </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endforeach; ?>
