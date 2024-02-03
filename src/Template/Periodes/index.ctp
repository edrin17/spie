<?php 
    $this->assign('title', 'Périodes'); 
    $this->set('modalTitle','Ajouter une nouvelle activité');
?> 
<?php echo $this->Form->create($periode); ?>
<h1>Périodes</h1>

<div class="row">
    <div class="col-lg-3">
        <?php echo $this->Form->input('referential_id', [
            'label' => 'Filtrer par Référentiel:',
            'onchange' => 'filterProgressionsByReferential()',
            'options' => $referentials,
            'default' => $referential_id
        ]); ?>
    </div>
    <div class="col-lg-3">
        <?php echo $this->Form->input('progression_id', [
            'label' => 'Filtrer par progression:',
            'onchange' => 'filterPeriodesByProgression()',
            'options' => $progressions,
            'default' => $progression_id
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-1 col-lg">
        <?php echo $this->element('/Modals/NewEntryPeriode'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table">
        <thead>
            <tr>
                <th>Nom de la période</th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($periodes as $periode): ?> <!--Affiche le contenu de 'periodes'  -->
                <tr> 
                    <td><?= h($periode->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
                    <td class="actions">
                    <!-- Affiche des urls/boutons et de leurs actions -->
                    <!-- Modal edit -->
                    <?php $this->set('object',$periode); ?>
                    <?php $this->set('progressions',$progressions); ?>
                    <?php $this->set('action','edit'); ?>
                    <?php $this->set('button','Editer'); ?>
                    <?php $this->set('buttonColor','primary'); ?>
                    <?php $this->set('icon','<i class="fa-solid fa-cog" aria-hidden="true">'); ?>
                    <?php echo $this->element('/Modals/EditPeriode'); ?>
                    <!-- /Modal edit -->
                    <!-- Button delete -->
                    <?php $this->set('object',$periode); ?>
                    <?php $this->set('action','delete'); ?>
                    <?php $this->set('icon','<i class="fa-solid fa-trash" aria-hidden="true">'); ?>
                    <?php $this->set('button','Supprimer'); ?>
                    <?php $this->set('buttonColor','danger'); ?>
                    <?php echo $this->element('/Modals/Delete'); ?>
                    <!-- /Button delete -->
                    </td>
                </tr>
                <?php endforeach ?>
        </tbody>       
    </table>
</div>


<script type="text/javascript">

    function filterPeriodesByProgression() {
        var referential_id = document.getElementById("referential-id").value;
        var progression_id = document.getElementById("progression-id").value;
        var url = "<?php echo $this->Url->build([
            'controller'=>'Periodes','action'=>'index']) ?>" 
            + "?referential_id=" + referential_id + "&progression_id=" + progression_id
        window.location = url; 
    }

    function filterProgressionsByReferential() {
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
    filterPeriodesByProgression();
    }
</script>
