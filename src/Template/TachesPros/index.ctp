<?php $this->assign('title', 'Liste des tâches professionnelles'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
        <table class="table">
    <h1>Liste des tâches professionnelles</h1>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?php echo $this->Html->link(__('Ajouter une tâche professionnelle'), ['action' => 'add', $activite_id]); ?>
    <?php echo $this->Form->create(); ?>
    <?php echo $this->Form->input('activite_id', [
        'label' => 'Filtrer par activités',
        'options' => $listeActivites,
        'default' => $activite_id
    ]); ?>
    <?php echo $this->Form->button(__('Filtrer')); ?>
    <?php echo $this->Form->end(); ?>    
        <thead>
            <tr>
                <th> Activités </th>
                <th> Tâches professionnelles </th>
                <th> Autonomie </th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tachesPros as $tachesPro): ?> <!--Affiche le contenu de 'activitess'  -->
            <tr> 
                <td><?php echo h($tachesPro->activite->NumeNom); ?></td>
                <td><?php echo h("T." .$tachesPro->activite->numero.
					"." .$tachesPro->numero .": ".$tachesPro->nom); ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
				<td><?php echo h($tachesPro->autonomy->NumeNom); ?></td>
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $tachesPro->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $tachesPro->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $tachesPro->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $tachesPro->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
     

</div>

