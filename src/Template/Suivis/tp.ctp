<?php
$vue = $this;
function editButton($tp){
    if (!isset($tp['contenu'])) {
        $tp['contenu'] = '';
    }
    $tp['contenu'] .= '<button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal"';
    $tp['contenu'] .= ' data-target="#myModal';
    $tp['contenu'] .= $tp['eleve_id'].'-'.$tp['tp_id'];
    $tp['contenu'] .= '"><i class="fa-solid fa-cog" aria-hidden="true"></i></button>';
    return $tp;
}
function deleteButton($tp, $vue, $rotation_id,  $classe_id, $periode_id, $spe){
    return $vue->Html->link(
        '<i class="fa-solid fa-trash" aria-hidden="true"></i>',
        ['controller' => 'Suivis',
            'action' => 'delete',
            1,
            '?' => [
                'periode' => $periode_id,
                'rotation' => $rotation_id,
                'classe' => $classe_id,
                'tp_id' => $tp['tp_id'],
                'spe' => $spe,
                ]
        ],[
        'confirm' => 'Etes-vous sûr de voulour supprimer le TP: '.$tp['tp_nom']." pour l'élève:".$tp['eleve_nom'].'.?' ,
            'escape'=> false,
            'class' => "btn btn-default",'role' => 'button'
        ]

    );

}
function evalButton($tp, $vue, $rotation_id,  $classe_id, $periode_id, $spe){
    return $vue->Html->link(
        'Evaluer',
        ['controller' => 'Evaluations',
            'action' => 'evaluate',
            1,
            '?' => [
                'periode' => $periode_id,
                'rotation' => $rotation_id,
                'classe' => $classe_id,
                'tp_id' => $tp['tp_id'],
                'eleve_id' => $tp['eleve_id'],
                'spe' => $spe,
            ]
        ],['class' => "btn btn-default",'role' => 'button']
    );

}
function pronote($tp, $vue, $rotation_id,  $classe_id, $periode_id){
    if ($tp['pronote']) {
        $tp['contenu'] = 'Pronote: <span class="label label-success label-as-badge">Ok</span>';
    } else {
        $tp['contenu'] = 'Pronote: <span class="label label-default label-as-badge">Non</span>';
    }
    return $tp['contenu'];
}
function note($tp, $rotation_id,  $classe_id, $periode_id){
    if ($tp['note']) {
        $tp['contenu'] = 'Note: <span class="label label-info label-as-badge">'.$tp['note'].'</span><br>';
    } else {
        $tp['contenu'] = 'Note: <span class="label label-default label-as-badge">Non</span><br>';
    }
    return $tp['contenu'];
}

function state($tp, $vue, $rotation_id,  $classe_id, $periode_id, $spe){
    if (is_null($tp['debut'])) {
        $tp = editButton($tp);

    }elseif ($tp['fin'] != null){
        $tp['contenu'] = 'Début: <span class="label label-success label-as-badge">'.date_format($tp['debut'],'d-m-Y')."</span><br>";
        $tp['contenu'] .= 'Fin: <span class="label label-success label-as-badge">'.date_format($tp['fin'],'d-m-Y')."</span><br>";
        $tp['contenu'] .= note($tp, $rotation_id,  $classe_id, $periode_id);
        $tp['contenu'] .= 'Base: '.isBase($tp, $vue, $rotation_id,  $classe_id, $periode_id);
        $tp['contenu'] .=pronote($tp, $vue, $rotation_id,  $classe_id, $periode_id);
        $tp['contenu'] = editButton($tp)['contenu'];
        $tp['contenu'] .= deleteButton($tp, $vue, $rotation_id,  $classe_id, $periode_id, $spe);
    }else{
        $tp['contenu'] = 'Début: <span class="label label-info label-as-badge">'.date_format($tp['debut'],'d-m-Y')."</span><br>";
        $tp['contenu'] = editButton($tp)['contenu'];
        $tp['contenu'] .= deleteButton($tp, $vue, $rotation_id,  $classe_id, $periode_id, $spe);
    }
    //debug($tp);die;
    return $tp;
}

function tabProcess($tableau, $vue, $rotation_id,  $classe_id, $periode_id , $spe){
    $tab = null;
    foreach ($tableau as $eleve => $tps) {
        foreach ($tps as $tp => $cell) {
            $tab[$eleve][$tp] = state($cell,$vue, $rotation_id,  $classe_id, $periode_id, $spe);
        }
    }
    return $tab;
}

function inputDebut($date){
    if ($date !== null) {
        $html = 'value="'.date_format($date,'Y-m-d').'"';
        return $html;
    }
}
function inputIsFini($date){
    if ($date !== null) {
        $html = ' checked';
        return $html;
    }
}

function inputFin($date){
    if ($date !== null) {
        $html = 'value="'.date_format($date,'Y-m-d').'"';
    }else {
        $html = ' disabled';
    }
    return $html;
}
function isBase($tp, $vue, $rotation_id,  $classe_id, $periode_id){
    $html = '<span class="label '.$tp['base']['label_color'].' label-as-badge">'.$tp['base']['value'].'</span><br>';
    return $html;
}
function inputRadioOui($state){
    if ($state == true) {
        $html = ' checked';
        return $html;
    }
}
function inputRadioNon($state){
    if ($state == false) {
        $html = ' checked';
        return $html;
    }
}
function inputNote($note){
    if ($note !== null) {
        $html = ' value="'.$note.'"';
        return $html;
    }
}
function inputMemo($memo){
    if ($memo !== null) {
        $html = h($memo);
    }else{
        $html = '';
    }
    return $html;
}
if ($spe) {
    $html['spe'] = 0;
    $html['label'] = 'Voir les TP normaux';
    $html['color'] = 'btn-success';
}else {
    $html['spe'] = 1;
    $html['label'] = 'Voir les TP spécifiques';
    $html['color'] = 'btn-warning';
}

$tableau = tabProcess($tableau, $vue, $rotation_id,  $classe_id, $periode_id, $spe);
//debug($tableau);die;

$this->start('tableauClasseur');
echo $this->element('TableauxClasseurs/suivi_tp2');
$this->end();
echo $this->fetch('tableauClasseur');
?>
<div class="row">
    <div class="col-md-8">
        <?php /*echo $this->Html->link($html['label'],
            ['action' => 'tp',1,
                '?' => [
                    'periode' => $periode_id,
                    'rotation' => $rotation_id,
                    'spe' => $html['spe'],
                    'classe' => $classe_id,
                ]
            ],['class' => "btn ".$html['color'],'role' => 'button' ]); */?>
    </div>
</div>

<table class="table table-hover">
    <thead>
        <tr>
            <th> </th>
            <?php foreach ($listTpHead as $header) :?>
                <th> <?php echo $header->nom ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($tableau)): ?>
            <?php foreach ($tableau as $cell => $key ) :?>
                <tr>
                    <td><b><?php echo $cell ?></b></td>
                    <?php foreach ($key as $eleve => $value) :?>
                        <td><?php echo $value['contenu'] ?> </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php if (isset($tableau)): ?>
    <?php foreach ($tableau as $cell => $key ) :?>
        <?php foreach ($key as $eleve => $tp) :?>
            <?php echo $this->Form->create(); ?>
            <?php echo $this->Form->hidden('eleve_id',['value' =>$tp['eleve_id']]) ?>
            <?php echo $this->Form->hidden('tp_id',['value' =>$tp['tp_id']]) ?>
            <?php echo $this->Form->hidden('classe_id',['value' =>$classe_id]) ?>
            <?php echo $this->Form->hidden('rotation_idId',['value' =>$rotation_id]) ?>
            <?php echo $this->Form->hidden('periode_idId',['value' =>$periode_id]) ?>
            <?php echo $this->Form->hidden('spe',['value' =>$spe]) ?>
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
                        <div class="row">
                            <div class="col-md-3">
                                <label>Début TP:</label>
                                <input type="date" class="form-control" name="date_debut" id="date_debut_<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>" <?php echo inputDebut($tp['debut'])?> required>
                            </div>
                            <div class="col-md-2">
                                <label>TP fini:</label>
                                <input type="checkbox" id="blankCheckbox" value="false" onclick="document.getElementById('date_fin_<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>').disabled = changeDateFinState(document.getElementById('date_fin_<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>').disabled)" <?php echo inputIsFini($tp['fin'])?>>
                            </div>
                            <div class="col-md-3">
                                <label>Fin du TP:</label>
                                <input type="date" class="form-control" name="date_fin" id="date_fin_<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>" <?php echo inputFin($tp['fin'])?>>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="note" >Note:</label>
                                <input type="number" class="form-control" max=10 name="note" id="note<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>" <?php echo inputNote($tp['note'])?>>
                            </div>
                            <div class="col-md-3">
                                <label>Pronote: </label>
                                <input type="radio" name="pronote" id="radio1<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>" value="true" <?php echo inputRadioOui($tp['pronote'])?>> Oui
                                <input type="radio" name="pronote" id="radio2<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>" value="false"<?php echo inputRadioNon($tp['pronote'])?>> Non
                            </div>
                            <div class="col-md-3">
                                <label>Base: </label>
                                <?php echo isBase($tp, $vue, $rotation_id,  $classe_id, $periode_id ) ?>
                                <?php echo evalButton($tp, $vue, $rotation_id,  $classe_id, $periode_id, $spe) ?>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea  name="memo" class="form-control" rows="5" id="memo<?php echo $tp['eleve_id'].'-'.$tp['tp_id'] ?>" placeholder="Memo ici"><?php echo inputMemo($tp['memo'])?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer"><!-- modal-footer -->
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        <button type="sumbit" class="btn btn-primary">Sauvegarder</button>
                    </div><!-- /modal-footer -->
                </div>
              </div>
            </div>
            <?php echo $this->Form->end(); ?>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>

<script>
function changeDateFinState(state) {
    if (state) {
        return false;
    } else {
        return true;
    }

}
</script>
