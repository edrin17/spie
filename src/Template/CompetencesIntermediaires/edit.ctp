<div class="users form large-9 medium-8 columns content">
    <?php echo $this->Form->create($competencesIntermediaire); ?>
    <fieldset>
        <legend><?php echo __('Editer une compétence intermédaire') ?></legend>
        <?php $optionToutVoir = 0; ?>
        <?php echo $this->Form->input('capacite_id', [
			'label' => 'Capacité correspondante dans le référentiel',
            'onchange' => 'select_capacites(this)',
            'options' => $listeCapacites           
            ]);?>
        
        <?php echo $this->Form->input('competences_terminale_id', [
            'label' => 'Compétence terminale correspondante dans le référentiel'
        ]);?>
        
        <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>
        <?php echo $this->Form->input('numero',[
            'label' => 'Numéro de la compétence intermédiaire',
            'option' => 'number'
        ]); ?>
            
    </fieldset>
    <?php echo $this->Form->button(__('Editer')); ?>
    <?php echo $this->Form->end(); ?>

</div>
<script>
function select_capacites(id)
{
    var id = id.value;
	$.get("<?php echo $this->Url->build([
					'controller'=>'CompetencesIntermediaires',
					'action'=>'listeCompetencesTerminales'])
					."/?optionToutVoir=" .$optionToutVoir; ?>"
					+ "&capacite_id=" +id, function(resp) {
          $('#competences-terminale-id').html(resp);
     });
    
}
</script>
