<?php $this->assign('title', 'Référentiels'); ?>  <!-- Customise le titre de la page -->
<h1>Liste des Référentiels</h1>
<div class="row">
    <div class="col-md-3">
        <?php echo $this->Html->link(
            'Ajouter un référential',
            ['action' => 'add'],
            ['class' => "btn btn-info", 'role' => 'button']
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
    <table id ="tableau" class="table table-hover">
        <thead>
            <tr>
                <th> Nom </th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($referentials as $referential): ?> <!--Affiche le contenu de 'referentials'  -->
            <tr>
                <td><?php echo h($referential->name) ?></td>
                <td class="actions">
                    <div class="btn-group" role="group">
                        <?php echo $this->Html->link('<i class="fa-solid fa-cog btn btn-default" aria-hidden="true"></i>', [
                            'controller' => 'Referentials',
                            'action' => 'edit',
                            $referential->id,
                        ],['role'=>'button', 'escape' => false]) ?>
                        <?php echo $this->Form->postButton(
                            '<i class="fa-solid fa-trash" aria-hidden="true"></i>',
                            ['controller' => 'referentials', 'action' => 'delete', $referential->id, '?' => [
                                'Referential' => $referential->referential_id]],
                            ['confirm' => 'Etes-vous sûr de voulour supprimer le TP: ' . $referential->name . '?', 'escape' => false]
                        ); ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
