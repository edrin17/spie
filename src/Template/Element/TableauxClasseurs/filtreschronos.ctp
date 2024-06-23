
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-2">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Filtrer par Référentiel',
                'onchange' => 'filterProgressionsByReferential()',
                'default' => $referential_id
            ]); ?>
        </div>
        <div class="col-lg-3">
            <?php echo $this->Form->input('progression_id', [
                'label' => 'Filtrer par Progression:',
                'onchange' => 'filterPage()',
                'default' => $progression_id
            ]); ?>
        </div>
    </div>
</div>

<script type="text/javascript">

    function filterPage() {
        var $referential_id = document.getElementById("referential-id").value;
        var $progression_id = document.getElementById("progression-id").value;
        var url = "<?php echo $this->Url->build(['controller' => $controller, 'action' => 'index']) ?>" +
            "/?referential_id=" + $referential_id +
            "&progression_id=" + $progression_id;
        window.location = url;
    }

    function filterProgressionsByReferential() {
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
        filterPage();
    }
</script>