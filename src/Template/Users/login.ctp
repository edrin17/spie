<?= $this->Form->create() ?>
    <?= $this->Form->input('username',['label' => 'Login']) ?>
    <?= $this->Form->input('password') ?>
    <?= $this->Form->button("S'identifier") ?>
<?= $this->Form->end() ?>
