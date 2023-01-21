<div class="container-fuild">
    <div class="row">
        <div class="col-lg-3">
            <?php echo $this->Form->input('progression_id', [
                'label' => 'Filtrer par progression:',
                'onchange' => 'filterClassesByProgression()',
                'default' => $progression_id
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $this->Form->input('classe_id', [
                'label' => 'Choix de classe',
                'onchange' => 'filterElevesByClasse()',
                'default' => $classe_id
            ]); ?>
        </div>
        <div class="col-lg-4">
            <?php echo $this->Form->input('eleve_id', [
                'label' => 'Choix de l\'élève:',
                'onchange' => 'filterPage()',
                'default' => $eleve_id
            ]); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
function filterClassesByProgression()
{   
    var $progression_id = document.getElementById("progression-id").value;
    $.get("<?php echo $this->Url->build(['controller'=>'FiltresAjaxes','action'=>'chainedClassesByProgression']) ?>" +
        "/?progression_id=" + $progression_id,
        function(resp) {
            $('#classe-id').html(resp);
            $('#classe-id').trigger("onchange");
        }
    );
}
function filterElevesByClasse()
{   
    var $progression_id = document.getElementById("progression-id").value;
    var $classe_id = document.getElementById("classe-id").value;
    $.get("<?php echo $this->Url->build(['controller'=>'FiltresAjaxes','action'=>'chainedElevesByClasse']) ?>" +
        "/?progression_id=" + $progression_id +
        "&classe_id=" + $classe_id,
        function(resp) {
            $('#eleve-id').html(resp);
            $('#eleve-id').trigger("onchange");
        }
    );
}

    function filterPage() {
        var $progression_id = document.getElementById("progression-id").value;
        var $classe_id = document.getElementById("classe-id").value;
        var $eleve_id = document.getElementById("eleve-id").value;
        //window.alert($eleve_id);
        var url = "<?php echo $this->Url->build(['controller' => 'Suivis', 'action' => 'suivi']) ?>" +
            "/?progression_id=" + $progression_id +
            "&classe_id=" + $classe_id +
            "&eleve_id=" + $eleve_id;
        window.location = url;
    }
</script>