<div class="marques form large-9 medium-8 columns content">
    <?= $this->Form->create($marque) ?>
    <fieldset>
        <legend><?= __('Ajouter une marque') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div>
