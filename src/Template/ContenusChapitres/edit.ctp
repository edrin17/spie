<div class="users form large-9 medium-8 columns content">
    <?php echo $this->Form->create($contenusChapitre); ?>
    <fieldset>
        <legend><?php echo __('Éditer un sous-sous chapitre') ?></legend>
        <?php echo $this->Form->create(); ?>
        <?php echo __('Filtres:') ?>
        
		<?php echo $this->Form->input('chapitre_id', [
			'onchange' => 'select_chapitre(this)',
            'options' => $listeChapitres
        ]);?>
		
		<?php echo $this->Form->input('sous_chapitre_id', [
            'onchange' => 'select_souschap(this)',
            'options' => $listeSousChapitres
        ]);?>
        
        <?php echo $this->Form->input('sous_sous_chapitre_id', [
            'label' => 'Sous sous chapitre correspondant dans le référentiel',
            'options' => $listeSousSousChapitres
        ]);?>       		
 
        <?php $optionToutVoir = 0?>
        
        <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>
        
        <?php echo $this->Form->input('numero',[
            'label' => 'Numéro du contenus de Chapitre',
            'option' => 'number', 
            'min' => '1',
            'max' => '10'
        ]); ?>
        
        <?php echo $this->Form->input('niveaux_taxo_id', [
			'label' => 'Niveau taxonomique correspondant dans le référentiel',
            'options' => $listeNiveaux
            ]);?>
        
        <?= $this->Form->input('contenu',['label' => 'Contenu:', 'type' => 'textarea', 'placeholder' => 'Contenu de chapitre ici...']); ?>            
    </fieldset>
    <?php echo $this->Form->button(__('Éditer')); ?>
    <?php echo $this->Form->end(); ?>
</div>
<script>
function select_chapitre(id)
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
function select_souschap(id)
{
    var id = id.value;
	$.get("<?php echo $this->Url->build([
					'controller'=>'ContenusChapitres',
					'action'=>'listeSousSousChapitres'])
					."/?optionToutVoir=" .$optionToutVoir; ?>"
					+ "&sous_chapitre_id=" +id, function(resp) {
          $('#sous-sous-chapitre-id').html(resp);
     });
    
}
</script>   
