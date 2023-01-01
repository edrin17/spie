<div class="container-fuild">
    <div class="row">
        <div class="col-lg-2">
            <?php echo $this->Form->input('progression_id', [
                'label' => 'Filtrer par référentiel:',
                'onchange' => 'filterPeriodesByProgression()',
                'default' => $progression_id
            ]); ?>
        </div>
        <div class="col-lg-2">
            <?php echo $this->Form->input('periode_id', [
                'label' => 'Filtrer par période',
                'onchange' => 'filterRotationsByPeriode()',
                'default' => $periode_id
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $this->Form->input('rotation_id', [
                'label' => 'Filtrer par rotation',
                'onchange' => 'filterPage()', //car c'est le référentiel qui indique la classe
                'default' => $rotation_id
            ]); ?>
        </div>
        <div class="col-lg-4" hidden>
            <?php echo $this->Form->input('classe_id', [
                'label' => 'Choix de classe',
                'default' => $classe_id
            ]); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function filterPeriodesByProgression() {
        var $progression_id = document.getElementById("progression-id").value;
        $.get("<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedPeriodesByProgression']) ?>" +
            "/?progression_id=" + $progression_id,
            function(resp) {
                $('#periode-id').html(resp);
                $('#periode-id').trigger("onchange");
            }
        );
    }

    function filterRotationsByPeriode() {
        var $periode_id = document.getElementById("periode-id").value;
        $.get("<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedRotationsByPeriode']) ?>" +
            "/?periode_id=" + $periode_id,
            function(resp) {
                $('#rotation-id').html(resp);
                $('#rotation-id').trigger("onchange");
            }
        );
    }

    function filterPage() {
        var $progression_id = document.getElementById("progression-id").value;
        var $periode_id = document.getElementById("periode-id").value;
        var $rotation_id = document.getElementById("rotation-id").value;
        var url = "<?php echo $this->Url->build(['controller' => 'Analyses', 'action' => 'index']) ?>" +
            "/?progression_id=" + $progression_id +
            "&periode_id=" + $periode_id +
            "&rotation_id=" + $rotation_id;
        window.location = url;
    }
</script>