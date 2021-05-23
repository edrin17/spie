<?php $this->assign('title', 'Liste des Matériels'); ?>  <!-- Customise le titre de la page -->

<h1>Propriétaires</h1>
<!-- Affiche le bouton ajouter un activite -->
<?= $this->Html->link(__('Ajouter un matériel'), ['action' => 'add']); ?>
<table id ="tableau" class="display">
        <thead>
            <tr>
                <th> Nom </th>
                <th> Type de machine </th>
								<th> Marque </th>
								<th> Propriétaire </th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materiels as $materiel): ?> <!--Affiche le contenu de 'activites'  -->
            <tr>
                <td><?= "<b>" .h($materiel->nom) ."</b>" ?></td>
								<td><?= h($materiel->types_machine->nom) ?></td>
								<td><?= h($materiel->marque->nom) ?></td>
								<td><?= h($materiel->owner->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $materiel->id]); ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $materiel->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $materiel->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $materiel->id)]); ?>
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
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/French.json"
        }
    });
} );
</script>
