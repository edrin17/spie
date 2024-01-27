<?php $this->assign('title', 'Association Objectifs Pédas et T.P');
if ($spe) {
    $html['spe'] = 0;
    $html['label'] = 'Voir les TP normaux';
    $html['color'] = 'btn-success';
}else {
    $html['spe'] = 1;
    $html['label'] = 'Voir les TP spécifiques';
    $html['color'] = 'btn-warning';
}
?>

<div class="row">
    <div class="col-lg-3">
        <?php echo $this->Form->input('referential_id', [
            'label' => 'Filtrer par référentiel:',
            'onchange' => 'filtreByReferential()',
            'options' => $referentials,
            'default' => $referential_id
        ]); ?>
    </div>
    <div class="col-lg-3 col-lg-offset-6">
        <?php echo $this->Form->input('progression_id', [
            'label' => 'Filtrer par progression:',
            'onchange' => 'filtreByProgression()',
            'options' => $progressions,
            'default' => $progression_id
        ]); ?>
    </div>  
</div>


<table class = 'table table-bordered table-hover'>
    <thead>
        <tr>
        <?php foreach($tableHeader as $key => $nom): ?>
            <th><?= $nom ?></th>
        <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tableau as $ligne): ?>
        <tr>
            <?php for ($i = 0; $i <= $nbColonnes; $i++): ?>
            <td rel="popover" data-toggle="popover" data-placement="left" data-container= "td" data-html="true" title= "<?= $ligne[$i]['contenu'] ?>">
                <?= $ligne[$i]['nom'] ?>
                <?= $ligne[$i]['nbTPs'] ?>
            </td>
            <?php endfor ?>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
//active l'uilisation de code html dans le tooltip
$("[rel=popover").popover({html:true});

//filter table on click
function filtreByProgression() {
    var referential_id = document.getElementById("referential-id").value;
    var progression_id = document.getElementById("progression-id").value;
    var url = "<?php echo $this->Url->build([
        'controller'=>'TravauxPratiquesObjectifsPedas','action'=>'view']) ?>" 
        + "?referential_id=" + referential_id + "&progression_id=" + progression_id;
    window.location = url;
}

function filtreByReferential() {
        var referential_id = document.getElementById("referential-id").value;

        // Generate the URL using a script block
        var url = "<?php echo $this->Url->build([
                'controller' => 'FiltresAjaxes',
                'action' => 'chainedProgressionsByReferential'
            ]); ?>/?referential_id=" + referential_id;
        
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

        // Update the dropdown with the response
        $('#progression-id').html(response);

        // Call the next function in the sequence
        filtreByProgression();
    }
</script>

