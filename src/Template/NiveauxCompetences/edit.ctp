<div class="niveauxCompetence form large-9 medium-8 columns content">
    <?= $this->Form->create($niveauxCompetence) ?>
    <fieldset>
        <legend><?= __('Édition du niveau de compétence') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
        <?= $this->Form->input('numero',['label' => 'Numéro']); ?>
    </fieldset>
    <?= $this->Form->button(__('Éditer')) ?>
    <?= $this->Form->end() ?>>
</div>
