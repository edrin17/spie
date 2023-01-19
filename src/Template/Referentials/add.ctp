<?php echo $this->Form->create($referential); ?>
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-12">
            <label for="name">Nom du référentiel</label>
            <?php echo $this->Form->text('name', [
                'id' => 'name',
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
    <div class='row'>
        <div class="col-lg-12">
            <?php echo $this->Form->button('Enregistrer', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
        </div>
    </div>
</div>

<?php echo $this->Form->end(); ?>