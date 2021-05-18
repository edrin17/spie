<?php $this->assign('title', 'Liste des Élèves'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des Élèves</h1>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?php echo $this->Html->link(__('Ajouter un élève'), ['action' => 'add', $classe_id]); ?>
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
                <th> Classe </th>
                <th> Nom </th>             
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eleves as $eleve): ?> <!--Affiche le contenu de 'activitess'  -->
            <tr> 
				<td><?php echo h($eleve->class->nom); ?></td>
				<td><?php echo strtoupper(h($eleve->nom)) .'<br>' .h($eleve->prenom) ; ?></td>
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $eleve->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $eleve->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $eleve->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $eleve->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>
