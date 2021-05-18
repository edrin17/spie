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
<label for="comments">Remarques</label>
<?= $this->Form->textarea('comments',[
	'id' => 'rotation-id',
	'class' => 'form-control']
); ?>
</div>

<div class="form-group">
<?= $this->Form->button('Éditer le TP',['type' => 'submit', 'class' => 'btn btn-primary']); ?>
</div>

<?= $this->Form->end(); ?>
