<?php $this->assign('title', 'Valeurs des évaluations'); ?>  <!-- Customise le titre de la page -->
<h1>Valeurs des évaluations</h1>
<?= $this->Html->link(__('Ajouter une valeur d\'évaluation'), ['action' => 'add']); ?>
<table class="table">  
	<thead>
		<tr>
			<th><?= $this->Paginator->sort('nom','Nom la valeur d\'évaluation'); ?></th>
			<th><?= $this->Paginator->sort('numero','Numero d\'importance'); ?></th>
			<th class="actions"><h3><?= __('Actions'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($valeursEvals as $valeursEval): ?> <!--Affiche le contenu de 'valeursEvals'  -->
		<tr> 
			<td style = "background-color:<?= $valeursEval->color ?>">
				<?= h($valeursEval->nom) ?>
			</td>
			<td><?= h($valeursEval->numero) ?></td>
			<td class="actions">
			<!-- Affiche des urls/boutons et de leurs actions -->
			<p>
				<?= $this->Html->link(__('Voir'), ['action' => 'view', $valeursEval->id]); ?>
				<?= $this->Html->link(__('Editer'), ['action' => 'edit', $valeursEval->id]); ?>
				<?= $this->Form->postLink(__('Supprimer'),
					['action' => 'delete', $valeursEval->id],
					['confirm' => __('Etes vous sûr de vouloir supprimer la valeur: "{0}" ?', $valeursEval->nom)]
				); ?>
			</p>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>       
</table>



