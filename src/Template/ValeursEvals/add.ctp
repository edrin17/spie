<?= $this->Form->create($valeursEval) ?>
<legend><?= __("Ajouter une valeur d'évaluation") ?></legend>
	<?= $this->Form->input('nom',['label' => 'Nom']); ?>
	<?= $this->Form->input('numero',[
			'label' => "Numéro d'ordre",
			'option' => 'number', 
			'min' => '-1',
			'max' => '10'
	]); ?>
	<?php //debug($colors); die; ?>
	<?= $this->Form->input('color',[
			'label' => "Couleur de la compétence",
			'options' => $colors
	]); ?>
<?= $this->Form->button(__('Envoyer')) ?>
<?= $this->Form->end() ?>

