<div class="periodes form large-9 medium-8 columns content">
    <?php echo $this->Form->create($periode) ?>
    <fieldset>
        <legend><?php echo __('Ajouter une période') ?></legend>
        <?php echo $this->Form->input('numero',['label' => 'Numéro']); ?>
        <?php echo $this->Form->input('classe_id',['label' => 'Choix de la classe',
			'options' => $listeClasses
		]);?>
        <?php echo $this->Form->input('progression_id',['label' => 'Choix du référentiel',
			'options' => $progressions
		]);?>
		<?= $this->Form->input('color',[
				'label' => 'Couleur de la période',
				'options' => $colors
			]);
		?>
    </fieldset>
    <?php echo $this->Form->button(__('Envoyer')) ?>
    <?php echo $this->Form->end() ?>
</div>
