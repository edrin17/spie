
<?php $this->assign('title', 'Utilisateurs') ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des utilisateurs</h1>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('Id') ?></th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
                <th><?= $this->Paginator->sort('Nom') ?></th>
                <th><?= $this->Paginator->sort('Prénom') ?></th>
                <th><?= $this->Paginator->sort('Privilèges') ?></th>
                <th class="actions"><h3><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?> <!--Affiche le contenu de 'users'  -->
            <tr> 
                <td><?= h($user->id) ?></td>
                <td><?= h($user->nom) ?></td>
                <td><?= h($user->prenom) ?></td>
                <td><?= h($user->privileges) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $user->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $user->id)]) ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?= $this->Html->link(__('Ajouter un utilisateur'), ['action' => 'add']) ?>
    <!-- Affiche le paginator -->
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('précedent')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('suivant') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>

