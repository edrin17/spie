<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="page-header">
            <h2><span class="label label-info">Ajout de matériel</span></h2>
        </div>
    </div>
</div>

<?= $this->Form->create($materiel); ?>
    <div class="form-group">
      <?= $this->Form->input('nom',[
          'label' => 'Nom:',
          'class' => 'form-control',
          'required' => true
      ]); ?>
    </div>
    <div class="form-group">
      <?= $this->Form->input('marque_id', [
          'label' => 'Marque:',
          'class' => 'selectpicker',
          'data-live-search' => "true",
          'options' => $marques
      ]); ?>
    </div>

    <div class="form-group">
        <?= $this->Form->input('types_machine_id', [
            'label' => 'Type machine:' ,
            'class' => 'selectpicker',
            'data-live-search' => "true",
            'options' => $typesMachines
        ]); ?>
    </div>

    <div class="form-group">
      <?= $this->Form->input('owner_id',[
          'label' => 'Propriétaire:',
          'class' => 'selectpicker',
          'data-live-search' => "true",
          'options' => $owners
      ]); ?>
    </div>

    <div class="form-group">
        <?= $this->Form->input('numero',[
            'class' => 'form-control',
            'label' => 'Numéro:'
        ]); ?>
    </div>

    <div class="form-group">
      <?= $this->Form->input('infos_chassis',[
          'label' => 'Infos Châssis:',
          'type' => 'textarea',
          'class' => 'form-control',
      ]); ?>
    </div>

    <div class="form-group">
      <?= $this->Form->input('date_entree',[
        'label' => "Date d'entrée",
        'class' => 'form-control',
      ]); ?>
    </div>

    <p class="bg-danger"> Si le matériel est dans l'atelier mettre une date de sortie inférieur à la date d'entrée</p>
    <div class="form-group bg-danger">
      <?= $this->Form->input('date_sortie',[
          'label' => "Date de sortie",
          'class' => 'form-control',
      ]); ?>
    </div>

    <div class="form-group">
        <?= $this->Form->input('infos_moteur',[
            'label' => 'Infos Moteurs:',
            'type' => 'textarea',
            'class' => 'form-control',
        ]); ?>
    </div>

    <div class="form-group">
            <?= $this->Form->input('infos',[
                'label' => 'Infos Maintenance',
                'type' => 'textarea',
                'class' => 'form-control',
            ]); ?>
    </div>

    <div class="form-group">
      <?= $this->Form->button(__('Envoyer'),[
        'class' => 'btn btn-success'
      ]); ?>
    </div>

<?= $this->Form->end(); ?>
