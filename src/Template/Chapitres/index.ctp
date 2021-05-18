
<?php $this->assign('title', 'Liste des Chapitres'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des Chapitres</h1>
    <?php echo $this->Html->link(__('Ajouter un chapitre'), ['action' => 'add']); ?>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('numero','Numéro'); ?> </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
                <th><?php echo $this->Paginator->sort('nom','Nom du chapitre'); ?></th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chapitres as $chapitre): ?> <!--Affiche le contenu de 'chapitres'  -->
            <tr>
                <td><?php echo "S.".h($chapitre->numero) ?></td>
                <td><?php echo h($chapitre->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $chapitre->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $chapitre->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $chapitre->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $chapitre->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Affiche le paginator -->
    <div class="paginator">
        <ul class="pagination">
            <?php echo $this->Paginator->prev('< ' . __('précedent')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next(__('suivant') . ' >'); ?>
        </ul>
        <p><?php echo $this->Paginator->counter(); ?></p>
    </div>
</div>
