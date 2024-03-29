<div class="container-fuild">
    <div class="row">
        <div class="col-lg-3">
            <?php echo $this->Form->input('progression_id', [
                'label' => 'Filtrer par progression:',
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
        <div class="col-lg-3">
            <?php echo $this->Form->input('classe_id', [
                'label' => 'Filtrer par classe:',
                'onchange' => 'filterPage()',
                'default' => $classe_id
            ]); ?>
        </div>
    </div>
</div>

<script type="text/javascript">

function filterPage()
{
    var $progression_id = document.getElementById("progression-id").value;
    var $periode_id = document.getElementById("periode-id").value;
    var $classe_id = document.getElementById("classe-id").value;
    var $rotation_id = document.getElementById("rotation-id").value;
    var url = "<?php echo $this->Url->build(['controller'=>'Suivis','action'=>'tp']) ?>" +
        "/?progression_id=" + $progression_id +
        "&periode_id=" + $periode_id +
        "&classe_id=" + $classe_id +
        "&rotation_id=" + $rotation_id;
	window.location = url;
}

function filterClassesByProgression()
{   
    var $progression_id = document.getElementById("progression-id").value;
    url = "<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedClassesByProgression']) ?>" +
    "/?progression_id=" + $progression_id;
    // Perform synchronous AJAX request using $.ajax
    var response;
    $.ajax({
        url: url,
        async: false, // Make the request synchronous
        type: "GET",
        success: function(data) {
            response = data;
        }
    });     
    $('#classe-id').html(response);
}

function filterRotationsByPeriode() {
    var $periode_id = document.getElementById("periode-id").value;
    url = "<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedRotationsByPeriode']) ?>" +
        "/?periode_id=" + $periode_id;
    // Perform synchronous AJAX request using $.ajax
    var response;
    $.ajax({
        url: url,
        async: false, // Make the request synchronous
        type: "GET",
        success: function(data) {
            response = data;
        }
    });
    $('#rotation-id').html(response);
    filterPage()
}

function filterPeriodesByProgression() {
    filterClassesByProgression();
    var $progression_id = document.getElementById("progression-id").value;
    url = "<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedPeriodesByProgression']) ?>" +
        "/?progression_id=" + $progression_id;
    // Perform synchronous AJAX request using $.ajax
    var response;
    $.ajax({
        url: url,
        async: false, // Make the request synchronous
        type: "GET",
        success: function(data) {
            response = data;
        }
    });     
    $('#periode-id').html(response);
    filterRotationsByPeriode();
}

</script>
