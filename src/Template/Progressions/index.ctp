<?php $this->assign('title', 'Progressions'); ?>  <!-- Customise le titre de la page -->
<h1>Liste des Progressions</h1>
<div class="row">
    <div class="col-md-3">
        <?php echo $this->Html->link(
            'Ajouter une progression',
            ['action' => 'add', '?' => [
                'referential_id' => $referential_id]],
            ['class' => "btn btn-info", 'role' => 'button']
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
    <table id ="tableau" class="table table-hover">
        <thead>
            <tr>
                <th> Progression </th>
                <th> Référentiel</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($progressions as $progression): ?> <!--Affiche le contenu de 'progressions'  -->
            <tr>
                <td><?php echo h($progression->nom) ?></td>
                <td><?php echo h($progression->Referential->name) ?></td>
                <td class="actions">
                    <div class="btn-group" role="group">
                        <?php echo $this->Html->link('<i class="fa-solid fa-cog btn btn-default" aria-hidden="true"></i>', [
                            'controller' => 'Progressions',
                            'action' => 'edit',
                            $progression->id,
                        ],['role'=>'button', 'escape' => false]) ?>
                        <?php echo $this->Form->postButton(
                            '<i class="fa-solid fa-trash" aria-hidden="true"></i>',
                            ['controller' => 'progressions', 'action' => 'delete', $progression->id, '?' => [
                                'progression' => $progression->progression_id]],
                            ['confirm' => 'Etes-vous sûr de voulour supprimer le TP: ' . $progression->name . '?', 'escape' => false]
                        ); ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
