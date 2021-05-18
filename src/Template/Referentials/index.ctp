<?php $this->assign('title', 'Référentiels'); ?>  <!-- Customise le titre de la page -->

<h1>Référentiels</h1>
<table id ="tableau" class="display">
        <thead>
            <tr>
                <th> Nom du référentiel </th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($referentials as $referential): ?> <!--Affiche le contenu de 'referentials'  -->
            <tr>
                <td><?= h($referential->name) ?></td>
                <td class="actions">
                <p>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $referential->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $referential->id],['confirm' => __('Etes vous sûr de vouloir supprimer "{0}" ?', $referential->name)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>
<!-- Affiche le bouton ajouter un referential -->
<?= $this->Html->link(__('Ajouter un référentiel'), ['action' => 'add']); ?>

<script>
$(document).ready(function() {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
        }
    });
} );
</script>
