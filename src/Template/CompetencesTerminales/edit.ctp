<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($compTerm) ?>
    <fieldset>
        <legend><?= __("Édition d'une compétence terminale") ?></legend>
            <?= $this->Form->input('capacite_id', [
                'label' => 'Capacité correspondante dans le référentiel',
                'options' => $listCapa
                //'default' => $filtrCapa
            ]);?>
            <?= $this->Form->input('nom',['label' => 'Nom']); ?>
            <?= $this->Form->input('numero',[
                'label' => 'Numéro de la Compétence Terminale',
                'option' => 'number'
            ]); ?>
            
    </fieldset>
    <?= $this->Form->button(__('Éditer')) ?>
    <?= $this->Form->end() ?>
</div>
