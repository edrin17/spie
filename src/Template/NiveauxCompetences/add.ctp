<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($niveauxCompetence) ?>
    <fieldset>
        <legend><?= __('Ajouter un niveau de compétence') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
        <?= $this->Form->input('numero',['label' => 'Numéro']); ?>
    </fieldset>
    <?= $this->Form->button(__('Ajouter')) ?>
    <?= $this->Form->end() ?>
</div>
