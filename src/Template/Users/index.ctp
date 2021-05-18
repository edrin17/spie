<?php $this->assign('title', 'Utilisateurs') ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
    <h1>Liste des utilisateurs</h1>    
        <table class="table">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('Login') ?></th>
                <th><?= $this->Paginator->sort('Nom') ?></th>
                <th><?= $this->Paginator->sort('Prénom') ?></th>
                <th><?= $this->Paginator->sort('Privilège') ?></th>              
                <th class="actions"><h3><?= __('Actions') ?></h3></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?> <!--Affiche le contenu de 'users'  -->
            <tr> 
				<?php //debug($user);die; ?>
                <td><?= h($user->username) ?></td>
                <td><?= h($user->nom) ?></td>
                <td><?= h($user->prenom) ?></td>
                <td><?= h($user->nom_privilege) ?></td>
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
    <?= $this->Html->link(__('Ajouter un utilisateur'), ['action' => 'add']) ?>
</div>

