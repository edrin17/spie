<div class="activites form large-9 medium-8 columns content">
    <?= $this->Form->create($progression) ?>
    <fieldset>
        <legend><?= __('Ajouter un référentiel') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
    </fieldset>
    <?= $this->Form->button(__('Sauvegarder')) ?>
    <?= $this->Form->end() ?>
</div>
