<?php $this->assign('title', 'Liste des compétences terminales'); ?>  <!-- Customise le titre de la page -->
<?= $this->Form->create() ?>
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des compétences terminales</h1>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?= $this->Html->link(__('Ajouter une compétence'), ['action' => 'add', 'filtrCapa' => $filtrCapa]) ?>

    <?= $this->Form->input('filtrCapa', [
        'label' => 'Filtrer par capacité',
        'options' => $listCapa
    ]); ?>
    <?= $this->Form->button(__('Filtrer')) ?>

		<thead>
            <tr>
                <th> Capacités </th>
                <th> Compétences Terminale </th>
                <th class="actions">
					<h3><?= __('Actions') ?>
				</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listeCompsTerms as $listeCompsTerm): ?> <!--Affiche le contenu de 'capacitess'  -->
            <tr> 
                <td><?= h($listeCompsTerm->capacite->fullName) ?></td>
                <td><?= h($listeCompsTerm->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(
						__('Voir'),['action' => 'view', $listeCompsTerm->id]
					)?>
                    <?= $this->Html->link(
						__('Editer'),['action' => 'edit', $listeCompsTerm->id]
					)?>
                    <?= $this->Form->postLink(
						__('Supprimer'),['action' => 'delete', $listeCompsTerm->id],
                        ['confirm' => __(
							'Etes vous sur de vouloirs supprimer # {0}?', $listeCompsTerm->id
						)]
					)?>
                </p>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>       
    </table>
    
</div>

<?= $this->Form->end() ?>
