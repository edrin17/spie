<?php echo $this->Form->create($progression); ?>
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-2">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Filtrer par référentiel:',
                'onchange' => 'filterProgressionsByReferential()',
                'default' => $referential_id
            ]); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="nom">Nom de la progression</label>
            <?php echo $this->Form->text('nom', [
                'id' => 'nom',
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
    function filterProgressionsByReferential() {
        var $referential_id = document.getElementById("referential-id").value;
        $.get("<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedProgressionsByReferential']) ?>" +
            "/?referential_id=" + $referential_id
        );
    }
</script>