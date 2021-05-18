<nav class="large-1 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Utilisateurs'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Bookmarks'), ['controller' => 'Bookmarks', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Bookmark'), ['controller' => 'Bookmarks', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users view large-9 medium-8 columns content">
    <h3><?= h($user->nom) ?> <?= h($user->prenom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Nom') ?></th>
            <td><?= h($user->nom) ?></td>
        </tr>
        <tr>
            <th><?= __('Prénom') ?></th>
            <td><?= h($user->prenom) ?></td>
        </tr>
        <tr>
            <th><?= __('Privilèges') ?></th>
            <td><?= h($user->privileges) ?></tr>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($user->id) ?></tr>
        </tr>
    </table>
    <?php /*
    <div class="related">
        <h4><?= __('Related Bookmarks') ?></h4>
        <?php if (!empty($user->bookmarks)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><?= __('Id') ?></th>
                <th><?= __('User Id') ?></th>
                <th><?= __('Title') ?></th>
                <th><?= __('Description') ?></th>
                <th><?= __('Url') ?></th>
                <th><?= __('Created') ?></th>
                <th><?= __('Modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($user->bookmarks as $bookmarks): ?>
            <tr>
                <td><?= h($bookmarks->id) ?></td>
                <td><?= h($bookmarks->user_id) ?></td>
                <td><?= h($bookmarks->title) ?></td>
                <td><?= h($bookmarks->description) ?></td>
                <td><?= h($bookmarks->url) ?></td>
                <td><?= h($bookmarks->created) ?></td>
                <td><?= h($bookmarks->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Bookmarks', 'action' => 'view', $bookmarks->id]) ?>

                    <?= $this->Html->link(__('Edit'), ['controller' => 'Bookmarks', 'action' => 'edit', $bookmarks->id]) ?>

                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Bookmarks', 'action' => 'delete', $bookmarks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookmarks->id)]) ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </div> */ ?>
</div>

