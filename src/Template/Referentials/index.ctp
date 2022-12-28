<?php $this->assign('title', 'Référentiels'); ?>  <!-- Customise le titre de la page -->
<h1>Référentiels</h1>
<div class="row">
    <div class="col-lg-12">
    <table id ="tableau" class="display" class="table">
        <thead>
            <tr>
                <th> Nom du référentiel </th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($referentials as $referential): ?> <!--Affiche le contenu de 'referentials'  -->
            <tr>
                <td><?= h($referential->nom) ?></td>
                <td class="actions">
                <p>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $referential->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $referential->id],['confirm' => __('Etes vous sûr de vouloir supprimer "{0}" ?', $referential->nom)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- Affiche le bouton ajouter un referential -->
<?= $this->Html->link(__('Ajouter un référentiel'), ['action' => 'add']); ?>
