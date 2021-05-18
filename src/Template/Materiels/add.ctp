<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="page-header">
            <h2><span class="label label-info">Création d'un nouveau matériel</span></h2>
        </div>
    </div>
</div>
<?= $this->Form->create(null,['class' => 'form-horizontal']); ?>

    <div class="form-group">

        <label for="nom" class="col-lg-1 control-label">
            Nom:
        </label>
        <div class="col-lg-2">
            <?= $this->Form->input('nom',[
                'label' => false,
                'class' => 'form-control',
                'placeholder' => 'Ex: Iseki 450 GT',
                'required' => true
            ]); ?>
        </div>
    </div>
    <div class="form-group">
        <label for="marque_id" class="col-lg-1 control-label">
            Marque:
        </label>
        <div class="col-lg-2">
            <?= $this->Form->input('marque_id', [
                'label' => false,
                'class' => 'selectpicker',
                'data-live-search' => "true",
                'options' => $marques
            ]); ?>
        </div>

        <label for="types_machine_id" class="col-lg-2 control-label">
            Type de machine:
        </label>
        <div class="col-lg-2">
            <?= $this->Form->input('types_machine_id', [
                'label' => false ,
                'class' => 'selectpicker',
                'data-live-search' => "true",
                'options' => $typesMachines
            ]); ?>
        </div>
    </div>

    <div class="form-group">

        <label for="owner_id" class="col-lg-1 control-label">
            Propriétaire:
        </label>
        <div class="col-lg-2">
            <?= $this->Form->input('owner_id',[
                'label' => false,
                'class' => 'selectpicker',
                'data-live-search' => "true",
                'options' => $owners
            ]); ?>
        </div>

        <label for="numero" class="col-lg-2 control-label">
            Numéro:
        </label>
        <div class="col-lg-1">
            <?= $this->Form->input('numero',[
                'class' => 'form-control',
                'label' => false,
                'type' => 'number'
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-4">
            <?= $this->Form->input('infos_chassis',[
                'label' => 'Infos Châssis',
                'type' => 'textarea',
                'class' => 'form-control',
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?= $this->Form->input('infos_moteur',[
                'label' => 'Infos Moteurs',
                'type' => 'textarea',
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-lg-8">
            <?= $this->Form->input('infos',[
                'label' => 'Infos Maintenance',
                'type' => 'textarea',
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>


    <?= $this->Form->button(__('Ajouter'),['class' => 'btn btn-success']); ?>


<?= $this->Form->end(); ?>
