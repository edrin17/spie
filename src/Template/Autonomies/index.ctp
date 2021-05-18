
<?php $this->assign('title', 'Niveaux d\'autonomie'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Niveaux d'autonomie</h1>
    <!-- Affiche le bouton ajouter un autonomie -->
    <?php echo $this->Html->link(__('Ajouter un niveau d\'autonomie'), ['action' => 'add']); ?>
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('numero','Niveau'); ?> </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
                <th><?php echo $this->Paginator->sort('nom','Nom du niveau d\'autonomie'); ?></th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($autonomies as $autonomie): ?> <!--Affiche le contenu de 'autonomies'  -->
            <tr> 
                <td><?php echo "N.".h($autonomie->numero) ?></td>
                <td><?php echo h($autonomie->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $autonomie->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $autonomie->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $autonomie->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $autonomie->id)]); ?>
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

