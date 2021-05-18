<?php
    $this->extend('/Common/tableauClasseur');
?>



<table class = "table table-bordered table-hover">
	<thead>
		<tr>
			<th>Travaux Pratiques à évaluer</th>
            <th>État</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listTps as $tp): ?>
			<tr data-toggle="modal" data-target="#myModal<?= "-". h($tp->id) ?>" >
				<td ><?= h("TP: " .$tp->fullName) ?></td>
                <td><span class="label <?= $tp->evaluated['label_color'] ?>">
                    <?= $tp->evaluated['value'] ?>
                </span></td>
			</tr>
        <?php endforeach; ?>    			
	</tbody>
</table>

<?php foreach ($listTps as $tp): ?>
<?= $this->Form->create() ?>

<!-- Modal-<?= h($tp->nom). ' - ' . h($selectedEleve->fullName) ?> -->

<?php   // on renvoi les paramètres selectedLVL1 selectedLVL2 selectedEleve pour rafraichir la page
        // On concatene tout ca avec l'id du TP
        $uuid = '"tpId_'.$tp->id.'_selectedLV1_'.$selectedLVL1.'_selectedLV2_'.
            $selectedLVL2->id.'_options_'.$options.'"';
?>
<input type="hidden" name=<?= $uuid ?>>
<div class="modal fade bs-example-modal-lg" id="myModal<?= "-". h($tp->id) ?>" tabindex="-1" role="dialog" aria-labelledby="<?= "-". $tp->id  ?>">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Évaluation du TP: <?= h($tp->fullName) ?></h4>
        </div>
        <div class="modal-body">
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
                    <td><?= h($objPeda->fullName) ?></td>
                    <td>
                        <div class="form-group">
                        <select class="selectpicker" name= <?= '"valeursEval_'.$idEval.'"' ?> data-width="auto">
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
                                    echo '<option value="'. h($key).'" '.h($selected) .'>'.
                                            h($value).
                                        '</option>';
                                    
                                }else{
                                    echo '<option value="'. h($key).'"' .'>'.
                                            h($value).
                                        '</option>';
                                }
                            }?>
                        </select>
                        </div><!-- /form-group-->
                    </td>
                    <td>
                        <div class="form-group">
                        <select class="selectpicker" name=<?= '"typeEval_'.$idEval.'"' ?> data-width="auto">
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
                                    echo '<option value="'. h($key).'" '.h($selected) .'>'.
                                        h($value).
                                    '</option>';    
                                    
                                }else{
                                    echo '<option value="'. h($key).'"' .'>'.
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
<?= $this->Form->end() ?>

<?php endforeach; ?>


