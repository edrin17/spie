<?php
$vue = $this;
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
        $tp['contenu'] = $vue->Html->link(('Debut'),
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

        );
        //$tp['contenu'] = '<a href="/spie/suivis/start/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].' " '.'class="btn btn-default" role="button">Commencer</a>' ;
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
