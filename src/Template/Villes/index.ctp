
<?php $this->assign('title', 'Marques'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Marques</h1>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('nom','Nom de la marque'); ?></th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($marques as $marque): ?> <!--Affiche le contenu de 'marques'  -->
            <tr> 
                <td><?= h($marque->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $marque->id]); ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $marque->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $marque->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $marque->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
    <!-- Affiche le bouton ajouter un marque -->
    <?= $this->Html->link(__('Ajouter une marque'), ['action' => 'add']); ?>
    <!-- Affiche le paginator -->
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('précedent')); ?>
            <?= $this->Paginator->numbers(); ?>
            <?= $this->Paginator->next(__('suivant') . ' >'); ?>
        </ul>
        <p><?= $this->Paginator->counter(); ?></p>
    </div>
</div>

