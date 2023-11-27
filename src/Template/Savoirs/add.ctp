<!--  
   TODO: #1 List all tree items plus "<Racine>" and add dynamically sublists
-->
<?php echo $this->Form->create($savoir); ?>
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-3">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Filtrer par référentiel:',
                'default' => $referential_id
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="nom">Nom du savoir</label>
            <?php echo $this->Form->text('nom', [
                'id' => 'nom',
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="num">Numéro</label>
            <?php echo $this->Form->text('num', [
                'id' => 'num',
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