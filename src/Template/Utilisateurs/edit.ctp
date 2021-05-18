<nav class="large-1 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Utilisateurs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bookmarks'), ['controller' => 'Bookmarks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bookmark'), ['controller' => 'Bookmarks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edition de l\'utilisateur') ?></legend>
        <?php
            echo $this->Form->input('nom',['label' => 'Nom']);
            echo $this->Form->input('prenom',['label' => 'Prénom']);
            echo $this->Form->input('privileges',['label' => 'Privilèges']);
            
        ?>
    </fieldset>
    <?= $this->Form->button(__('Editer')) ?>
    <?= $this->Form->end() ?>
</div>
