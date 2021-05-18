<?php $this->assign('title', 'Liste des objectifs pédagogiques'); ?>
<h1>Liste des objectifs pédagogiques</h1>
<?= $this->Html->link(__('Ajouter un objectif pédagogique'), ['action' => 'add']); ?>
<table id ="tableau" class="display">
	<thead>
		<tr>
			<th>Identifiants</th>
			<th>Niveaux</th>
			<th>Objectifs Pédagogiques</th>
			<th class="actions"><h3><?= __('Actions'); ?></th>
		</tr>
	</thead>
	<tbody>
        <?php foreach ($listObjsPedas as $listObjsPeda): ?> <!--Affiche le contenu de 'chapitress'  -->
        <tr> 
			<td><?= h($listObjsPeda->code); ?></td>
			<td><?= h($listObjsPeda->niveaux_competence->nom); ?></td>
			<td><?= h($listObjsPeda->nom); ?></td>
			<td class="actions">			
				<p>
					<?= $this->Html->link(__('Voir'), ['action' => 'view', $listObjsPeda->id]); ?>
					<?= $this->Html->link(__('Editer'), ['action' => 'edit', $listObjsPeda->id]); ?>
					<?= $this->Form->postLink(__('Supprimer'),
						['action' => 'delete', $listObjsPeda->id],
						['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $listObjsPeda->id)]
					); ?>
				</p>
			</td>
        </tr>
        <?php endforeach; ?>
    </tbody>       
</table> 
<script>
$(document).ready(function() {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
        }
    });
} );
</script>
