
<?php $this->assign('title', 'Niveaux de Compétence'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Niveaux de compétence</h1>
        <thead>
    <!-- Affiche le bouton ajouter un niveauxCompetence -->
    <?php echo $this->Html->link(__('Ajouter un niveau de compétence'), ['action' => 'add']); ?>			
            <tr>
                <th><?php echo $this->Paginator->sort('numero','Numéro'); ?> </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
                <th><?php echo $this->Paginator->sort('nom','Nom du niveau de compétence'); ?></th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($niveauxCompetences as $niveauxCompetence): ?> <!--Affiche le contenu de 'niveauxCompetences'  -->
            <tr> 
                <td><?php echo h($niveauxCompetence->numero) ?></td>
                <td><?php echo h($niveauxCompetence->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $niveauxCompetence->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $niveauxCompetence->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $niveauxCompetence->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $niveauxCompetence->id)]); ?>
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

