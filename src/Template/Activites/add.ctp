<div class="activites form large-9 medium-8 columns content">
    <?= $this->Form->create($activite) ?>
    <fieldset>
        <legend><?= __('Ajouter une activité') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
        <?= $this->Form->input('numero',['label' => 'Numéro dans le référentiel']); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div>
