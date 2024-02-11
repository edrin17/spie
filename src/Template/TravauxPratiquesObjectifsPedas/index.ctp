<h1> Objectifs Pédas associés avec <font color = "#40CF40" ><?php echo h($tp->nom) ?> </font></h1>
<!-- Affiche le bouton ajouter un utilisateur -->
<?php echo $this->Html->link('Ajouter un objectif pédagogique pour ce TP',[
    'action' => 'add',
    $tp->id,'?' => [
		'referential_id' => $referential_id,
		'rotation_id' => $rotation_id,
		'periode_id' => $periode_id,
		'progression_id' => $progression_id,
		'classe_id'=> $classe_id,
		'spe' => $spe,
		'tp_id' => $tp->id
	]
    ],['class' => "btn btn-default",'role' => 'button']).PHP_EOL; ?>
<br>
<br>

<table id="tableau" class="display">
	<thead>
		<tr>
			<th>Identifiants</th>
			<th>Niveaux</th>
			<th>Objectifs Pédagogiques</th>
			<th class="actions"><h3><?php echo __('Actions') ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($listObjsPedas as $objPeda): ?>
		<?php $tpObjPeda = $objPeda->_matchingData['TravauxPratiquesObjectifsPedas']; ?>
		<?php //debug($objPeda);die; ?>
		<tr>
			<td><?php echo h($objPeda->code); ?></td>
			<td><?php echo h($objPeda->niveaux_competence->nom); ?></td>
			<td><?php echo h($objPeda->nom); ?></td>
			<td class="actions">
			<p>
				<?php echo $this->Form->postLink(__('Supprimer'),[
                        'action' => 'delete',
                        $tpObjPeda->id,
                        '?'=> [
							'referential_id' => $referential_id,
							'rotation_id' => $rotation_id,
							'periode_id' => $periode_id,
							'progression_id' => $progression_id,
							'classe_id'=> $classe_id,
							'spe' => $spe,
							'tp_id' => $tp->id
						],
                    ],
					['confirm' => __('Etes vous sur de vouloirs supprimer {0}?',
						$objPeda->fullName)
					]
				) ?>
			</p>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php echo $this->Html->link('Retour au TP',[
    'controller' => 'TravauxPratiques',
    'action' => 'index',
    $tp->id,'?' => [
		'referential_id' => $referential_id,
		'rotation_id' => $rotation_id,
		'periode_id' => $periode_id,
		'progression_id' => $progression_id,
		'classe_id'=> $classe_id,
		'spe' => $spe
	]
    ],['class' => "btn btn-default",'role' => 'button']).PHP_EOL; ?>
<script>
$(document).ready( function () {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
        }
    });
} );
</script>
