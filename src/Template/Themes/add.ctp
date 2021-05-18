<div class="typesTaches form large-9 medium-8 columns content">
    <?= $this->Form->create($theme) ?>
    <fieldset>
        <legend><?= __('Ajouter un thème') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
        <?= $this->Form->input('color',[
				'label' => 'Couleur du thème',
				'options' => $colors
			]);
		?>
    </fieldset>
    <?= $this->Form->button(__('Ajouter')) ?>
    <?= $this->Form->end() ?>
</div>
