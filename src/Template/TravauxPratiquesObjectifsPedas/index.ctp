<h1> Objectifs Pédas associés avec <font color = "#40CF40" ><?= h($tp->nom) ?> </font></h1>
<!-- Affiche le bouton ajouter un utilisateur -->
<?= $this->Html->link(__('Ajouter un objectif pédagogique pour ce TP'),
	['action' => 'add', $id])
?>

<table id="tableau" class="display">    
	<thead>
		<tr>
			<th>Identifiants</th>
			<th>Niveaux</th>
			<th>Objectifs Pédagogiques</th>
			<th class="actions"><h3><?= __('Actions') ?></th>
		</tr>
	</thead>   
	<tbody>
		<?php foreach ($listObjsPedas as $objPeda): ?>
		<?php $tpObjPeda = $objPeda->_matchingData['TravauxPratiquesObjectifsPedas']; ?>
		<?php //debug($objPeda);die; ?>
		<tr> 
			<td><?= h($objPeda->code); ?></td>
			<td><?= h($objPeda->niveaux_competence->nom); ?></td>
			<td><?= h($objPeda->nom); ?></td>
			<td class="actions">
			<p>
				<?= $this->Form->postLink(__('Supprimer'),
					['action' => 'delete', $tpObjPeda->id],
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
<script>
$(document).ready( function () {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
        }
    });
} );
</script>
