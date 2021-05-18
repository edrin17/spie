<?php $this->assign('title', "Type d'évaluation'"); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Type d'évaluation</h1>
    <!-- Affiche le bouton ajouter un typesEvals -->
    <?= $this->Html->link(__('Ajouter un type d\'évaluation'), ['action' => 'add']); ?>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('nom','Nom du type d\'évaluation'); ?></th>
                <th><?= $this->Paginator->sort('numero','Numero d\'importance'); ?></th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($typesEvals as $typesEval): ?> <!--Affiche le contenu de 'typesEvalss'  -->
            <tr> 
                <td><?= h($typesEval->nom) ?></td>
                <td><?= h($typesEval->numero) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $typesEval->id]); ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $typesEval->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $typesEval->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $typesEval->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>

