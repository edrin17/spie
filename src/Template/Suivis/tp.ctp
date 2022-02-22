<?php
$vue = $this;
function editButton($tp){
    if (!isset($tp['contenu'])) {
        $tp['contenu'] = '';
    }
    $tp['contenu'] = $tp['contenu'].'<button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal"';
    $tp['contenu'] = $tp['contenu'].' data-target="#myModal';
    $tp['contenu'] = $tp['contenu'].$tp['eleve_id'].'-'.$tp['tp_id'];
    $tp['contenu'] = $tp['contenu'].'"><i class="fa fa-cog" aria-hidden="true"></i></button>';
    return $tp;
}
function pronote($tp,$vue, $selectedRotation,  $selectedClasse, $selectedPeriode){
    if ($tp['pronote']) {
        $tp['contenu'] = 'Pronote: <span class="label label-success label-as-badge">ok</span>';
    } else {
        $tp['contenu'] = $vue->Html->link(('Pronote'),
            [
                'action' => 'validate',1,
                '?' => [
                    'eleve' => $tp['eleve_id'],
                    'tp' => $tp['tp_id'],
                    'classe' => $selectedClasse,
                    'rotation' => $selectedRotation,
                    'periode' => $selectedPeriode,
                    'options' => 'pronote'
                    ]
            ],
            ['class' => "btn btn-default",'role' => 'button'],

        );

        //$tp['contenu'] = '<a href="/spie/suivis/validate/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].'&amp;option=pronote" '.'class="btn btn-default" role="button">Pronote</a>';
    }
    return $tp['contenu'];
}
function base($tp,$vue, $selectedRotation,  $selectedClasse, $selectedPeriode){
    if ($tp['base']) {
        $tp['contenu'] = 'Base: <span class="label label-success label-as-badge">ok</span><br>';
    } else {
        //$tp['contenu'] = '<a href="/spie/suivis/validate/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].'&amp;option=base" '.'class="btn btn-default" role="button">Base</a>';
        $tp['contenu'] = $vue->Html->link(('Base'),
            [
                'action' => 'validate',1,
                '?' => [
                    'eleve' => $tp['eleve_id'],
                    'tp' => $tp['tp_id'],
                    'classe' => $selectedClasse,
                    'rotation' => $selectedRotation,
                    'periode' => $selectedPeriode,
                    'options' => 'base'
                    ]
            ],
            ['class' => "btn btn-default",'role' => 'button'],

        );
    }
    return $tp['contenu'];
}
function note($tp,$vue, $selectedRotation,  $selectedClasse, $selectedPeriode){
    if ($tp['note']) {
        $tp['contenu'] = 'Noté: <span class="label label-success label-as-badge">ok</span><br>';
    } else {
        //$tp['contenu'] = '<a href="/spie/suivis/validate/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].'&amp;option=note" '.'class="btn btn-default" role="button">Noter</a>';
        $tp['contenu'] = $vue->Html->link(('Noter'),
            [
                'action' => 'validate',1,
                '?' => [
                    'eleve' => $tp['eleve_id'],
                    'tp' => $tp['tp_id'],
                    'classe' => $selectedClasse,
                    'rotation' => $selectedRotation,
                    'periode' => $selectedPeriode,
                    'options' => 'note'
                    ]
            ],
            ['class' => "btn btn-default",'role' => 'button'],

        );
    }
    return $tp['contenu'];
}

function state($tp,$vue, $selectedRotation,  $selectedClasse, $selectedPeriode){
    if (is_null($tp['debut'])) {
        /*$tp['contenu'] = $vue->Html->link(('Debut'),
            [
                'action' => 'start',1,
                '?' => [
                    'eleve' => $tp['eleve_id'],
                    'tp' => $tp['tp_id'],
                    'classe' => $selectedClasse,
                    'rotation' => $selectedRotation->id,
                    'periode' => $selectedPeriode,
                    ]
            ],
            ['class' => "btn btn-default",'role' => 'button'],

        );*/
        $tp = editButton($tp);
        //debug($tp);die;

    }elseif ($tp['fin'] != null){
        $tp['contenu'] = 'Début: <span class="label label-success label-as-badge">'.date_format($tp['debut'],'d-m-Y')."</span><br>";
        $tp['contenu'] = $tp['contenu'].'Fin: <span class="label label-success label-as-badge">'.date_format($tp['fin'],'d-m-Y')."</span><br>";
        $tp['contenu'] = $tp['contenu'].note($tp, $vue, $selectedRotation->id,  $selectedClasse, $selectedPeriode);
        $tp['contenu'] = $tp['contenu'].base($tp, $vue, $selectedRotation->id,  $selectedClasse, $selectedPeriode);
        $tp['contenu'] = $tp['contenu'].pronote($tp, $vue, $selectedRotation->id,  $selectedClasse, $selectedPeriode);
    }else{
        $tp['contenu'] = 'Début: <span class="label label-info label-as-badge">'.date_format($tp['debut'],'d-m-Y')."</span><br>";
        //$tp['contenu'] = $tp['contenu'].'<a href="/spie/suivis/end/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].'" '.'class="btn btn-default" role="button">Fini</a>' ;
        $tp['contenu'] = $tp['contenu'].$vue->Html->link(('Fini'),
            [
                'action' => 'end',1,
                '?' => [
                    'eleve' => $tp['eleve_id'],
                    'tp' => $tp['tp_id'],
                    'classe' => $selectedClasse,
                    'rotation' => $selectedRotation->id,
                    'periode' => $selectedPeriode,
                    ]
            ],
            ['class' => "btn btn-default",'role' => 'button'],

        );
    }
    //debug($tp);die;
    return $tp;
}

function tabProcess($tableau, $vue, $selectedRotation,  $selectedClasse, $selectedPeriode)
{
    foreach ($tableau as $eleve => $tps) {
        foreach ($tps as $tp => $cell) {
            $tab[$eleve][$tp] = state($cell,$vue, $selectedRotation,  $selectedClasse, $selectedPeriode);
        }
    }
    return $tab;
}
$tableau = tabProcess($tableau, $vue, $selectedRotation,  $selectedClasse, $selectedPeriode);
//debug($tableau);die;
?>



<?php
$this->start('tableauClasseur');
echo $this->element('TableauxClasseurs/suivi_tp');
$this->end();
echo $this->fetch('tableauClasseur');
?>
<table class="table table-hover">
    <thead>
        <tr>
            <th> </th>
            <?php foreach ($listTpHead as $header) :?>
                <th> <?php echo $header->travaux_pratique->nom ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tableau as $cell => $key ) :?>
            <tr>
                <td><b><?php echo $cell ?></b></td>
                <?php foreach ($key as $eleve => $value) :?>
                    <td><?php echo $value['contenu']?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php foreach ($tableau as $cell => $key ) :?>
    <?php foreach ($key as $eleve => $tp) :?>
        <!-- modal-for <?php echo $tp['eleve_nom'].'-'.$tp['tp_nom'] ?>-->
        <div class="modal fade bs-example-modal-lg" id="myModal<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>"  tabindex="-1" role="dialog" aria-labelledby="test">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $tp['eleve_nom'].'-'.$tp['tp_nom'] ?> </h4>
                </div>
                <div class="modal-body">

              </div>
              <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary" ?>
                        Sauvegarder
                    </button>
              </div><!-- /modal-footer -->
            </div>
          </div>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>
