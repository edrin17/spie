<div class="owners form large-9 medium-8 columns content">
    <?= $this->Form->create($owner) ?>
    <fieldset>
        <legend><?= __('Ajouter une owner') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div>
