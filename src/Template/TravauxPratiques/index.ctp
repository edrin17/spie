<?php
    $this->extend('/Common/tableauClasseur'); // Affiche les onglets
?>
<?php $this->assign('title', 'Travaux Pratiques'); ?>  <!-- Customise le titre de la page -->
<?= $this->Html->link(__('Ajouter un TP'), ['action' => 'add']); ?>
<table class="table">
        <thead>
            <tr>
				<th> Classe </th>
				<th> Place dans la progression </th>
                <th> Thèmes </th>
                <th> Nom du TP </th>
                <th><h3>Actions</h3></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listTPs as $tp): ?> <!--Affiche le contenu de 'activitess'  -->
            <tr>
                <td><?= h($tp->rotation->periode->classe->nom); ?></td>
                <td><?= h($tp->rotation->fullName); ?></td>
                <td><?= h($tp->rotation->theme->nom); ?></td>
                <td><?= h($tp->nom); ?></td>

				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $tp->id]); ?> -
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $tp->id]); ?> -
					<?= $this->Html->link(__('Voir les associations avec un objectif pédagogique'), [
						'controller' => 'TravauxPratiquesObjectifsPedas',
						'action' => 'index',
						$tp->id]); ?> -
					<?= $this->Html->link(__('Associer avec un objectif pédagogique'), [
						'controller' => 'TravauxPratiquesObjectifsPedas',
						'action' => 'add',
						$tp->id]); ?> -
					<?= $this->Html->link(__('Associer avec un matériel'), [
						'controller' => 'MaterielsTravauxPratiques',
						'action' => 'add',
						$tp->id]); ?> -
					<?= $this->Html->link(__('Voir les associations avec un matériel'), [
						'controller' => 'MaterielsTravauxPratiques',
						'action' => 'index',
						$tp->id]); ?> -
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $tp->id],['confirm' => __('Êtes vous sur de vouloirs supprimer le T.P: {0}?', $tp->nom)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
