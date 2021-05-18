<?= $this->Form->create($objectifsPeda); ?>
<legend><?= __('Ajouter un objectif pédagogique') ?></legend>		   
<?= $this->Form->input('niveaux_competence_id', [
	'label' => "Niveau de complexite de la compétence visée",		
	'options' => $listLvls
]);?>
<legend><?= __('Compétences associées') ?></legend>            
<?php //debug($objectifsPeda->competences_intermediaire->competences_terminale->capacite->id);die; ?>
<?= $this->Form->input('capacite_id', [
	'label' => 'Capacité correspondante dans le référentiel',
	'onchange' => 'select_comps_terms()',
	'default' => $objectifsPeda->competences_intermediaire->competences_terminale->capacite->id,
	'options' => $listCapas
]);?>  
<?= $this->Form->input('competences_terminale_id', [
	'label' => 'Compétence terminale correspondante dans le référentiel',
	'default' => $objectifsPeda->competences_intermediaire->competences_terminale->id,
	'onchange' => 'select_comps_inters()',
	'options' => $listCompsTerms
]);?>		
<?= $this->Form->input('competences_intermediaire_id', [
	'label' => 'Compétence intermédiaire correspondante dans le référentiel',
	'options' => $listCompsInters
]);?>


<div class ="form-group">
	<label for ="nom"><?= __('Ajouter un objectif') ?></label>
	<?= $this->Form->text('nom',[
		'label' => 'Nom du T.P',
		'class' => 'form-control'
	]); ?>
</div>	  
<?= $this->Form->button(__('Envoyer')); ?>
<?= $this->Form->end(); ?>

<?php $optionToutVoir = 0; ?>

<script>
function select_comps_terms()
{
    var id = document.getElementById("capacite-id").value;
    var idChild = document.getElementById("competences-terminale-id").value; 
	$.get("<?php echo $this->Url->build([
					'controller'=>'FiltresAjaxes',
					'action'=>'chainedCompsTerms'])
					."/?optionToutVoir=" .$optionToutVoir; ?>"
					+ "&parent_id=" +id, function(resp) {
          $('#competences-terminale-id').html(resp);
          $('#competences-terminale-id').trigger("onchange");
    });
}
function select_comps_inters()
{
    
    var id = document.getElementById("competences-terminale-id").value;
	$.get("<?php echo $this->Url->build([
					'controller'=>'FiltresAjaxes',
					'action'=>'chainedCompsInters'])
					."/?optionToutVoir=" .$optionToutVoir; ?>"
					+ "&parent_id=" +id, function(resp) {
          $('#competences-intermediaire-id').html(resp);
     });
    
}
</script>
