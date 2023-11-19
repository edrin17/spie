<?php echo $this->Form->create($capacite) ?>                       <!-- Crée un formulaire qui sera stocké d'un $capacité' -->
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-2">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Référentiel cible',
                'default' => $referential_id
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="nom">Nom de la capacité</label>
            <?php echo $this->Form->text('nom', [
                'id' => 'nom',
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1">
            <label for="numero">Numéro de la capacité</label>
            <?php echo $this->Form->number('numero', [
                'id' => 'numero',
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
