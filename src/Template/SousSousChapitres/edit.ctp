<div class="users form large-9 medium-8 columns content">
    <?php echo $this->Form->create($sousSousChapitre); ?>
    <fieldset>
        <legend><?php echo __('Éditer un sous-sous chapitre') ?></legend>
        <?php echo $this->Form->input('chapitre_id', [
			'label' => 'Chapitre correspondant dans le référentiel',
            'onchange' => 'select_cat(this)',
            'options' => $listeChapitres
            ]);?>
        
        <?php echo $this->Form->input('sous_chapitre_id', [
            'label' => 'Sous chapitre correspondant dans le référentiel',
            'options' => $selectSousChapitres
        ]);?>
        
        <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>
        <?php echo $this->Form->input('numero',[
            'label' => 'Numéro du sous-sous chapitre',
            'option' => 'number', 
            'min' => '0',
            'max' => '10'
        ]); ?>
        <?php $optionToutVoir = 0 ?>
   
    </fieldset>
    <?php echo $this->Form->button(__('Envoyer')); ?>
    <?php echo $this->Form->end(); ?>
</div>
 <script>
function select_cat(id)
{
    var id = id.value;
	$.get("<?php echo $this->Url->build([
					'controller'=>'SousSousChapitres',
					'action'=>'listeSousChapitres'])
					."/?optionToutVoir=" .$optionToutVoir; ?>"
					+ "&chapitre_id=" +id, function(resp) {
          $('#sous-chapitre-id').html(resp);
     });
    
}
</script>
