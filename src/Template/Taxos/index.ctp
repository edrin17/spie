<?php $this->assign('title', 'Niveaux taxonomiques'); ?>  <!-- Customise le titre de la page -->
<h1>Liste des niveaux taxonomiques</h1>
<div class="row">
    <div class="col-md-3">
        <?php echo $this->Html->link(
            'Ajouter un niveau taxonomique',
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
                <th> Niveau </th>
                <th> Nom </th>
                <th> Description </th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($taxos as $taxo): ?> <!--Affiche le contenu de 'taxos'  -->
            <tr>
                <td><?php echo h($taxo->num) ?></td>
                <td><?php echo h($taxo->name) ?></td>
                <td><?php echo h($taxo->content) ?></td>
                <td class="actions">
                    <div class="btn-group" role="group">
                        <?php echo $this->Html->link('<i class="fa-solid fa-cog btn btn-default" aria-hidden="true"></i>', [
                            'controller' => 'Taxos',
                            'action' => 'edit',
                            $taxo->id,
                        ],['role'=>'button', 'escape' => false]) ?>
                        <?php echo $this->Form->postButton(
                            '<i class="fa-solid fa-trash" aria-hidden="true"></i>',
                            ['controller' => 'taxos', 'action' => 'delete', $taxo->id, '?' => [
                                'Taxo' => $taxo->taxo_id]],
                            ['confirm' => 'Etes-vous sûr de voulour supprimer le TP: ' . $taxo->name . '?', 'escape' => false]
                        ); ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
