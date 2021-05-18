<?php $this->assign('title', 'Liste des sous-chapitres'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des Sous-Chapitres</h1>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?php echo $this->Html->link(__('Ajouter un sous-chapitre'), ['action' => 'add']); ?>
    <?php echo $this->Form->create(); ?>
    <?php echo $this->Form->input('chapitre_id', [
        'label' => 'Filtrer par chapitre',
        'options' => $listeChapitres,
        'default' => $chapitre_id
    ]); ?>
    <?php echo $this->Form->button(__('Filtrer')); ?>
    <?php echo $this->Form->end(); ?> 
        <thead>
            <tr>
                <th> Chapitres </th>
                <th> Sous-Chapitres </th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sousChapitres as $sousChapitre): ?> <!--Affiche le contenu de 'chapitress'  -->
            <tr> 
                <td><?php echo h("S." .$sousChapitre->chapitre->numero .": " .$sousChapitre->chapitre->nom); ?></td>
                <td><?php echo h("S." .$sousChapitre->chapitre->numero ."." .$sousChapitre->numero .": ".$sousChapitre->nom); ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $sousChapitre->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $sousChapitre->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $sousChapitre->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $sousChapitre->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>

