<div class="valeursEvals form large-9 medium-8 columns content">
    <?= $this->Form->create($typesEval) ?>
    <fieldset>
        <legend><?= __("Éditer un type d'évaluation") ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
        <?= $this->Form->input('numero',[
                'label' => 'Numéro d\'ordre',
                'option' => 'number', 
                'min' => '0',
                'max' => '10'
            ]); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div>
