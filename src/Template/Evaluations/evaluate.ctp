<?php echo($this->Form->create()) ?>
<br>
<?php echo($this->Form->hidden('eleve_id',['value' =>$selectedEleve->id])) ?>
<?php echo($this->Form->hidden('tp_id',['value' =>$tp->id])) ?>
<?php echo($this->Form->hidden('tpEleve_id',['value' =>$tpEleve_id])) ?>
<?php echo($this->Form->hidden('selectedClasseId',['value' =>$classe_id])) ?>
<?php echo($this->Form->hidden('selectedRotationId',['value' =>$rotation_id])) ?>
<?php echo($this->Form->hidden('selectedPeriodeId',['value' =>$periode_id])) ?>
<h2 class=page-header><?php echo(h($selectedEleve->fullName).' - TP: '.h($tp->fullName)); ?> </h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Objectifs pédagogiques</th>
            <th>Valeur</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tp->objectifs_pedas as $objPeda): ?>
        <?php
            $selectionId = null;
            //on crée une chaîne identifiant les valeurs
            $idEval = 'tpId_'.$tp->id.'_objPeda_'.$objPeda->id;
        ?>
        <tr>
            <td><?php echo h($objPeda->fullName) ?></td>
            <td>
                <div class="form-group">
                <select class="selectpicker" name=valeurEval-<?php echo($objPeda->id); ?> data-width="auto">
                    <?php foreach ($listValeursEvals as $key => $value) {
                        if (isset($existingData[$tp->id])) {
                            if (isset($existingData[$tp->id][$objPeda->_joinData->objectifs_peda_id])) {
                                    $selectionId = $existingData[$tp->id][
                                        $objPeda->_joinData->objectifs_peda_id]
                                    ->valeurs_eval_id;
                            }

                            if ($key === $selectionId) {
                                $selected = 'selected';
                            }else{
                                $selected = '';
                            }
                            echo '<option value="'.$key.'" '.$selected.'>'.
                                    h($value).
                                '</option>';

                        }else{
                            echo '<option value="'.$key.'"' .'>'.
                                    h($value).
                                '</option>';
                        }
                    }?>
                </select>
                </div><!-- /form-group-->
            </td>
            <td>
                <div class="form-group">
                <select class="selectpicker" name=typeEval-<?php echo($objPeda->id); ?> data-width="auto">
                    <?php foreach ($listTypesEvals as $key => $value) {
                        $selectionId = null;
                        if (isset($existingData[$tp->id])) {
                            if (isset($existingData[$tp->id][$objPeda->_joinData->objectifs_peda_id])) {
                                $selectionId = $existingData[$tp->id][$objPeda->_joinData->objectifs_peda_id]->types_eval_id;
                            }
                            if ($key === $selectionId) {
                                $selected = 'selected';
                            }else{
                                $selected = '';
                            }
                            echo '<option value="'.$key.'" '.$selected.'>'.
                                h($value).
                            '</option>';

                        }else{
                            echo '<option value="'.$key.'"' .'>'.
                                    h($value).
                                '</option>';
                        }
                    }?>
                </select>
                </div><!-- /form-group-->
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<button type="sumbit" class="btn btn-primary">Sauvegarder</button>


<?php echo $this->Form->end() ?>
