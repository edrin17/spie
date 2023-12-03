<?php echo $this->Form->create($competenceTerminale) ?>                       <!-- Crée un formulaire qui sera stocké d'un $capacité' -->
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-2">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Référentiel cible',
                'onchange' => 'filterCapacitesByReferential()',
                'default' => $referential_id
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10">
            <?php echo $this->Form->input('capacite_id', [
                'label' => 'Capacité cible',
                'default' => $capacite_id
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="nom">Nom de la compétence terminale</label>
            <?php echo $this->Form->text('nom', [
                'id' => 'nom',
                'class' => 'form-control',
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-1">
            <label for="numero">Numéro de la compétence terminale</label>
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

<script type="text/javascript">
    function filterCapacitesByReferential() {
        var referential_id = document.getElementById("referential-id").value;
        $.get("<?php echo $this->Url->build([
            'controller'=>'FiltresAjaxes',
            'action'=>'chainedCapacites'])
            ."/?referential_id="; ?>"
            + referential_id, function(resp) {
                $('#capacite-id').html(resp);
            }
        );
    }
</script>