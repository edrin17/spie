<?php
$this->assign('title', 'Liste des Matériels');
echo $this->Form->create($query); ?>
<h1>Liste des Matériels</h1>
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-2">
        <?= $this->Form->control('show_client',[
            'type' => 'checkbox',
            'label' => 'Matériel client uniquement',
        ]); ?> </div>

        <div class="col-lg-2">
        <?= $this->Form->control('wkshp_only',[
          'type' => 'checkbox',
          'label' => "Machine dans l'atelier uniquement",
        ]);?>
        </div>

        <div class="col-lg-2">
            <?= $this->Form->button('Filtrer'); ?>
        </div>
    </div>
    <div class="row">
        <?= $this->Html->link(('Ajouter un matériel'), ['action' => 'add']); ?>
    </div>
</div>
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
            <?php foreach ($query as $materiel): ?> <!--Affiche le contenu de 'activites'  -->
            <tr>
                <td><?= "<b>" .h($materiel->nom) ."</b>" ?></td>
								<td><?= h($materiel->types_machine->nom) ?></td>
								<td><?= h($materiel->marque->nom) ?></td>
								<td><?= h($materiel->owner->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $materiel->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $materiel->id],
                        ['confirm' => __('Etes vous sûr de vouloir supprimer  {0}?', $materiel->nom)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
<?= $this->Form->end(); ?>

<script>
$(document).ready(function() {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/French.json"
        }
    });
} );
</script>
