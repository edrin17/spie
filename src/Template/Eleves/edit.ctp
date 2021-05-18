<div class="eleves form large-9 medium-8 columns content">
    <?= $this->Form->create($eleve); ?>
    <fieldset>
        <legend><?= __('Éditer un élève') ?></legend>
            
            <?= $this->Form->input('nom',[
				'label' => 'Nom:',
			]); ?>
			
			<?= $this->Form->input('prenom',[
				'label' => 'Prénom:',
			]); ?>        
                      
            <?= $this->Form->input('classe_id', [
                'label' => 'Classe:',
                'options' => $classes
            ]); ?>             
			
    </fieldset>
    <?= $this->Form->button(__('Envoyer')); ?>
    <?= $this->Form->end(); ?>
</div>
