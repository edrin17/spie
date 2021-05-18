<?php $this->assign('title', 'Association Objectifs Pédas et T.P'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1> Objectifs Pédas associés avec <?= h($nomTP->nom) ?> </h1>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?= $this->Html->link(__('Ajouter un objectif pédagogique pour ce TP'), ['action' => 'add', $id]); ?>
        <thead>
            <tr>
                <th> Objectifs Pédas associés </th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listeTravauxPratiques as $listeTravauxPratique): ?> <!--Affiche le contenu de 'activitess'  -->
            <tr> 
                <td><?= h($listeObjectifs[$listeTravauxPratique->id]); ?></td>
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $listeTravauxPratique->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $listeTravauxPratique->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>
