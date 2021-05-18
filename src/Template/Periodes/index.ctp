<?php $this->assign('title', 'Périodes'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Périodes</h1>
    <!-- Affiche le bouton ajouter un periode -->
    <?= $this->Html->link(__('Ajouter une période'), ['action' => 'add', $classe_id]); ?>
    <?php echo $this->Form->create(); ?>
    <?php echo $this->Form->input('classe_id', [
        'label' => 'Filtrer par classes',
        'options' => $listeClasses,
        'default' => $classe_id
    ]); ?>
    <?= $this->Form->button(__('Filtrer')); ?>
    <?php echo $this->Form->end(); ?>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('classe','Classe'); ?></th>
                <th><?= $this->Paginator->sort('numero','Numéro'); ?> </th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($periodes as $periode): ?> <!--Affiche le contenu de 'periodes'  -->
            <?php //debug($periode);die; ?>
            <tr> 
                <td><?= h($periode->class->nom) ?></td>
                <td><?= "P.".h($periode->numero) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $periode->id]); ?>
                    <?= $this->Html->link(__('Éditer'), ['action' => 'edit', $periode->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $periode->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $periode->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>

