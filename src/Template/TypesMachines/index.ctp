
<?php $this->assign('title', 'Types Machines'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Types Machines</h1>
    <!-- Affiche le bouton ajouter un typesMachine -->
    <?= $this->Html->link(__('Ajouter un type de machine'), ['action' => 'add']); ?>    
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('nom','Nom des types de machine'); ?></th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($typesMachines as $typesMachine): ?> <!--Affiche le contenu de 'typesMachines'  -->
            <tr> 
                <td><?= h($typesMachine->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $typesMachine->id]); ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $typesMachine->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $typesMachine->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $typesMachine->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
    <!-- Affiche le paginator -->
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('Précedent')); ?>
            <?= $this->Paginator->numbers(); ?>
            <?= $this->Paginator->next(__('Suivant') . ' >'); ?>
        </ul>
        <p><?= $this->Paginator->counter(); ?></p>
    </div>
</div>

