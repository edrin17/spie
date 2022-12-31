<?php function isSpe($tp)
{
	if ($tp->specifique) {
		return "checked";
	}
	//debug($tp);die;
}
?>
<?php echo $this->Form->create($tp); ?>
<div class="container-fuild">
	<div class="row">
		<div class="col-lg-2">
			<?php echo $this->Form->input('referential_id', [
				'label' => 'Filtrer par référentiel:',
				'onchange' => 'filterPeriodesByReferential()',
				'default' => $referential_id
			]); ?>
		</div>
		<div class="col-lg-2">
			<?php echo $this->Form->input('periode_id', [
				'label' => 'Filtrer par période',
				'onchange' => 'filterRotationsByPeriode()',
				'default' => $periode_id
			]); ?>
		</div>
		<div class="col-lg-4">
			<?php echo $this->Form->input('rotation_id', [
				'label' => 'Filtrer par rotation',
				'onchange' => 'filterPage()', //car c'est le référentiel qui indique la classe
				'default' => $rotation_id
			]); ?>
		</div>
		<div class="col-lg-4">
			<?php echo $this->Form->input('classe_id', [
				'label' => 'Choix de classe',
				'default' => $classe_id
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<?php echo $this->Form->input('taches_principale_id', [
				'label' => 'Filtrer par rotation',
				'options' => $taches,
				'default' => $tache_id
			]); ?>
		</div>
	</div>
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

<script type="text/javascript">
	function filterPeriodesByReferential() {
		var $referential_id = document.getElementById("referential-id").value;
		filterClassesByReferential($referential_id);
		$.get("<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedPeriodesByReferential']) ?>" +
			"/?referential_id=" + $referential_id,
			function(resp) {
				$('#periode-id').html(resp);
				$('#periode-id').trigger("onchange");
			}
		);
	}

	function filterRotationsByPeriode() {
		var $periode_id = document.getElementById("periode-id").value;
		$.get("<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedRotationsByPeriode']) ?>" +
			"/?periode_id=" + $periode_id,
			function(resp) {
				$('#rotation-id').html(resp);
			}
		);
	}

	function filterClassesByReferential($referential_id) {
		$.get("<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedClassesByReferential']) ?>" +
			"/?referential_id=" + $referential_id,
			function(resp) {
				$('#classe-id').html(resp);
				$('#classe-id').trigger("onchange");
			}
		);
	}
</script>