<div class="typesMachines form large-9 medium-8 columns content">
    <?= $this->Form->create($typesMachine) ?>
    <fieldset>
        <legend><?= __('Ajouter un type de machine') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div>
