<div class="tachesPros form large-9 medium-8 columns content">
    <?php echo $this->Form->create($tachesPro); ?>
    <fieldset>
        <legend><?php echo __('Ajouter une tâche professionnelle') ?></legend>
            <?php echo $this->Form->input('activite_id', [
                'label' => 'Chapitre correspondant dans le référentiel',
                'options' => $listeActivites,
                'default' => $activite_id
            ]); ?>
            <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>       
            <?php echo $this->Form->input('numero',[
                'label' => 'Numéro de la tâche',
                'option' => 'number', 
                'min' => '1',
                'max' => '10'
            ]); ?>
            <?php echo $this->Form->input('autonomy_id', [
                'label' => 'Niveau d\'autonomie correspondant dans le référentiel',
                'options' => $listeAutonomies
                
            ]); ?>
            
        
    </fieldset>
    <?php echo $this->Form->button(__('Valider')); ?>
    <?php echo $this->Form->end(); ?>
</div>
