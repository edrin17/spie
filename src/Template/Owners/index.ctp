
<?php $this->assign('title', 'owners'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>owners</h1>
    <!-- Affiche le bouton ajouter un owner -->
    <?= $this->Html->link(__('Ajouter un propriétaire'), ['action' => 'add']); ?>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('nom','Nom du propriétaire'); ?></th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($owners as $owner): ?> <!--Affiche le contenu de 'owners'  -->
            <tr>
                <td><?= h($owner->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $owner->id]); ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $owner->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $owner->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $owner->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
