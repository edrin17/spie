<?= $this->Form->create($tp); ?>
<div class="form-group">
<label for="nom">Nom du TP</label>
<?= $this->Form->text('nom',[
		'id' => 'nom',
		'class' => 'form-control',
	]); ?>
</div>

<div class="form-group">
<label for="rotation-id">Choix de la rotation</label>
<?= $this->Form->select('rotation_id',
	$listRotations,[
	'id' => 'rotation-id',
	'class' => 'form-control']
); ?>
</div>

<div class="form-group">
<label for="tachesPros-id">Choix de la tâche professionnelle</label>
<?= $this->Form->select('taches_principale_id',
	$listTachesPro,[
	'id' => 'tachesPro-id',
	'class' => 'form-control']
); ?>
</div>

<div class="form-group">
<label for="comments">Elements du TP à modifier</label>
<?= $this->Form->textarea('comments',[
	'id' => 'rotation-id',
	'class' => 'form-control']
); ?>
</div>

<div class="form-group">
<label for="ressources">Ressources documentaires et matérielles</label>
<?= $this->Form->textarea('ressources',[
	'id' => 'rotation-id',
	'class' => 'form-control']
); ?>
</div>

<div class="form-group">
<label for="specifique">TP spécifique (hors progression)</label>
<?= $this->Form->checkbox('specifique',[
	'id' => 'rotation-id',
	'class' => 'form-control']
); ?>
</div>

<div class="form-group">
<?= $this->Form->button('Enregistrer',['type' => 'submit', 'class' => 'btn btn-primary']); ?>
</div>

<?= $this->Form->end(); ?>
