<div class="row">
    <div class="col-md-6 col-md-6">
        <div class="page-header">
            <h2><span class="label label-success">Création d'un nouvel utilisateur</span></h2>
        </div>
    </div>
</div>
<?= $this->Form->create($user,['class' => 'form-horizontal']); ?>
    <div class="form-group">
        
        <label for="prenom" class="col-md-1 control-label">
            Prénom:
        </label>
        <div class="col-md-2">
            <?= $this->Form->input('prenom',[
                'label' => false,
                'class' => 'form-control',
                'placeholder' => 'Ex: Jean',
                'required' => true
            ]); ?>
        </div>
        
        <label for="nom" class="col-md-1 control-label">
            Nom:
        </label>
        <div class="col-md-2">
            <?= $this->Form->input('nom',[
                'label' => false,
                'class' => 'form-control',
                'placeholder' => 'Ex: Dupont',
                'required' => true
            ]); ?>
        </div>
        
        <label for="privilege" class="col-md-1 control-label">
            Privilèges:
        </label>
        <div class="col-md-1">
            <?= $this->Form->input('privilege',[
                'label' => false,
                'class' => 'form-control',
                'required' => true,
                'type' => 'number'
            ]); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="nom" class="col-md-3 control-label">
            Nom d'utilisateur (login):
        </label>
        <div class="col-md-2">
            <?= $this->Form->input('username',[
                'label' => false,
                'class' => 'form-control',
                'placeholder' => 'jean.dupont',
                'required' => true
            ]); ?>
        </div>
        
        <label for="nom" class="col-md-2 control-label">
            Mot de passe:
        </label>
        <div class="col-md-2">
            <?= $this->Form->input('password',[
                'label' => false,
                'class' => 'form-control',
                'placeholder' => 'leMotDePasse',
                'required' => true,
                'type' => 'password'
            ]); ?>
        </div>
    </div>
    <?= $this->Form->button(__('Ajouter'),['class' => 'btn btn-success']); ?>
<?= $this->Form->end() ?>
