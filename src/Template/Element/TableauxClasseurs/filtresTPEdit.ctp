<div class="container-fuild">
    <div class="row">
        <div class="col-lg-2">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Filtrer par Référentiel',
                'onchange' => 'filterProgressionsByReferential()',
                'default' => $referential_id
            ]); ?>
        </div>
        <div class="col-lg-2">
            <?php echo $this->Form->input('progression_id', [
                'label' => 'Filtrer par Progression:',
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
                'default' => $rotation_id
            ]); ?>
        </div>
        <div class="col-lg-2">
            <?php echo $this->Form->input('classe_id', [
                'label' => 'Choix de classe',
                'default' => $classe_id
            ]); ?>
        </div>
    </div>
    <div class="row">
		<div class="col-lg-6">
			<?php echo $this->Form->input('activite_id', [
				'label' => 'Filtrer par Activité',
                'onchange' => 'filterTachesProsByActivite()',
				'options' => $activites,
				'default' => $activite_id
			]); ?>
		</div>
        <div class="col-lg-6">
			<?php echo $this->Form->input('taches_pro_id', [
				'label' => 'Filtrer par tâches',
				'options' => $tachesPros,
				'default' => $tache_pro_id
			]); ?>
		</div>
	</div>
</div>

<script type="text/javascript">

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
        filterPage();
    }

    function filterPeriodesByProgression() {
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
    
    function filterTachesProsByActivite() {
        var $activite_id = document.getElementById("activite-id").value;
        url = "<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedTachesProsByActivite']) ?>" +
            "/?activite_id=" + $activite_id;
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
        $('#taches-pro-id').html(response);
    }

    function filterActiviteByReferential() {
        var $referential_id = document.getElementById("referential-id").value;
        url = "<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedActivitesByReferential']) ?>" +
            "/?referential_id=" + $referential_id;
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
        $('#activite-id').html(response);     
        filterTachesProsByActivite();
    }

    function filterProgressionsByReferential() {
        filterActiviteByReferential();
        var $referential_id = document.getElementById("referential-id").value;
        url = "<?php echo $this->Url->build(['controller' => 'FiltresAjaxes', 'action' => 'chainedProgressionsByReferential']) ?>" +
            "/?referential_id=" + $referential_id;
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
        $('#progression-id').html(response);
        filterPeriodesByProgression();
    }
</script>