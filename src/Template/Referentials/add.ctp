<div class="activites form large-9 medium-8 columns content">
    <?= $this->Form->create($referential) ?>
    <fieldset>
        <legend><?= __('Ajouter un référentiel') ?></legend>
        <?= $this->Form->input('name',['label' => 'Nom']); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div>
