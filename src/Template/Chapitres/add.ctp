<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($chapitre) ?>
    <fieldset>
        <legend><?= __('Ajouter un chapitre') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
        <?= $this->Form->input('numero',['label' => 'Numéro dans le référentiel']); ?>
    </fieldset>
    <?= $this->Form->button(__('Valider')) ?>
    <?= $this->Form->end() ?>
</div>
