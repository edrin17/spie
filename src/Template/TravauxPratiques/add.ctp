<?php function isSpe($tp)
{
	if ($tp->specifique) {
		return "checked";
	}
	//debug($tp);die;
}
?>
<?php 
	echo $this->Form->create($tp);
	echo $this->element('TableauxClasseurs/filtresTPEdit');
?>
<div class="container-fuild">	
	<div class="row">
		<div class="col-lg-12">
			<label for="nom">Nom du TP</label>
			<?php echo $this->Form->text('nom', [
				'id' => 'nom',
				'class' => 'form-control',
			]); ?>
		</div>
	</div>
</div>


<div class="form-group">
	<label for="comments">Elements du TP à modifier</label>
	<?php echo $this->Form->textarea(
		'comments',
		[
			'id' => 'rotation-id',
			'class' => 'form-control'
		]
	); ?>
</div>

<div class="form-group">
	<label for="ressources">Ressources documentaires et matérielles</label>
	<?php echo $this->Form->textarea(
		'ressources',
		[
			'id' => 'rotation-id',
			'class' => 'form-control'
		]
	); ?>
</div>

<div class="form-group">
	<label for="specifique">TP spécifique (hors progression)</label>
	<input type="checkbox" name="specifique" id="specifique" value=1>
</div>


<div class="form-group">
	<?php echo $this->Form->button('Enregistrer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
</div>

<?php echo $this->Form->end(); ?>