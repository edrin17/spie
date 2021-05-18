<?php $this->assign('title', 'Thèmes'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Thèmes</h1>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('nom','Nom du thème'); ?></th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($themes as $theme): ?> <!--Affiche le contenu de 'themes'  -->
            <tr> 
                <td><?= h($theme->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $theme->id]); ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $theme->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $theme->id],['confirm' => __('Etes vous sûr de vouloir supprimer le thème: {0}?', $theme->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
    <!-- Affiche le bouton ajouter un theme -->
    <?= $this->Html->link(__('Ajouter un thème'), ['action' => 'add']); ?>
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

