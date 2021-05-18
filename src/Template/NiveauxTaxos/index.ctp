<?php $this->assign('title', 'Niveaux Taxonomiques'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Niveaux taxonomiques</h1>
    <!-- Affiche le bouton ajouter un niveauxTaxo -->
    <?php echo $this->Html->link(__('Ajouter un niveauxTaxo'), ['action' => 'add']); ?>        
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('numero','Numéro'); ?> </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
                <th><?php echo $this->Paginator->sort('nom','Nom du niveaux taxonomique'); ?></th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($niveauxTaxos as $niveauxTaxo): ?> <!--Affiche le contenu de 'niveauxTaxos'  -->
            <tr> 
                <td><?php echo "N.".h($niveauxTaxo->numero) ?></td>
                <td><?php echo h($niveauxTaxo->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $niveauxTaxo->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $niveauxTaxo->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $niveauxTaxo->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $niveauxTaxo->id)]); ?>
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

