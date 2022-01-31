<?php
function pronote($tp){
    if ($tp['pronote']) {
        $tp['contenu'] = 'Pronote: <span class="label label-success label-as-badge">ok</span>';
    } else {
        $tp['contenu'] = '<a href="/spie/suivis/validate/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].'&amp;option=pronote" '.'class="btn btn-default" role="button">Pronote</a>';
    }
    return $tp['contenu'];
}
function base($tp){
    if ($tp['base']) {
        $tp['contenu'] = 'Base: <span class="label label-success label-as-badge">ok</span><br>';
    } else {
        $tp['contenu'] = '<a href="/spie/suivis/validate/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].'&amp;option=base" '.'class="btn btn-default" role="button">Base</a>';
    }
    return $tp['contenu'];
}
function note($tp){
    if ($tp['note']) {
        $tp['contenu'] = 'Noté: <span class="label label-success label-as-badge">ok</span><br>';
    } else {
        $tp['contenu'] = '<a href="/spie/suivis/validate/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].'&amp;option=note" '.'class="btn btn-default" role="button">Noter</a>';
    }
    return $tp['contenu'];
}

function state($tp){
    if (is_null($tp['debut'])) {
        $tp['contenu'] = '<a href="/spie/suivis/start/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].' " '.'class="btn btn-default" role="button">Commencer</a>' ;
    }elseif ($tp['fin'] != null){
        $tp['contenu'] = 'Début: <span class="label label-success label-as-badge">'.date_format($tp['debut'],'d-m-Y')."</span><br>";
        $tp['contenu'] = $tp['contenu'].'Fin: <span class="label label-success label-as-badge">'.date_format($tp['fin'],'d-m-Y')."</span><br>";
        $tp['contenu'] = $tp['contenu'].note($tp);
        $tp['contenu'] = $tp['contenu'].base($tp);
        $tp['contenu'] = $tp['contenu'].pronote($tp);
    }else{
        $tp['contenu'] = 'Début: <span class="label label-info label-as-badge">'.date_format($tp['debut'],'d-m-Y')."</span><br>";
        $tp['contenu'] = $tp['contenu'].'<a href="/spie/suivis/end/1?eleve='.$tp['eleve_id'].'&amp;tp='.$tp['tp_id'].'" '.'class="btn btn-default" role="button">Fini</a>' ;
    }
    //debug($tp);die;
    return $tp;
}


function tabProcess($tableau)
{
    foreach ($tableau as $eleve => $tps) {
        foreach ($tps as $tp => $cell) {
            $tab[$eleve][$tp] = state($cell);
        }
    }
    return $tab;
}
$tableau = tabProcess($tableau);
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
