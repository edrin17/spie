<?php $this->assign('title', 'Capacités'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Capacités</h1>
    <?php echo $this->Html->link(__('Ajouter une capacité'), ['action' => 'add']); ?>
    <!-- Affiche le paginator -->
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('numero','Numéro'); ?> </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
                <th><?php echo $this->Paginator->sort('nom','Nom de la capacité'); ?></th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($capacites as $capacite): ?> <!--Affiche le contenu de 'capacites'  -->
            <tr> 
                <td><?php echo 'C.', h($capacite->numero) ?></td>
                <td><?php echo h($capacite->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $capacite->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $capacite->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $capacite->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $capacite->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <div class="paginator">
        <ul class="pagination">
            <?php echo $this->Paginator->prev('< ' . __('précedent')); ?>
            <?php echo $this->Paginator->numbers(); ?>
            <?php echo $this->Paginator->next(__('suivant') . ' >'); ?>
        </ul>
        <p><?php echo $this->Paginator->counter(); ?></p>
    </div>
</div>

