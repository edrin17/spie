<div class="users form large-9 medium-8 columns content">
    <?php echo $this->Form->create($sousChapitre); ?>
    <fieldset>
        <legend><?php echo __('Ajouter un sous-chapitre') ?></legend>
			<?php echo $this->Form->input('chapitre_id', [
                'label' => 'Chapitre correspondant dans le référentiel',
                'options' => $listeChapitres,
                'default' => $chapitre_id
            ]); ?>
            <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>       
            <?php echo $this->Form->input('numero',[
                'label' => 'Numéro du sous-chapitre',
                'option' => 'number', 
                'min' => '1',
                'max' => '10'
            ]); ?>
            
       
    </fieldset>
    <?php echo $this->Form->button(__('Envoyer')); ?>
    <?php echo $this->Form->end(); ?>
</div>
