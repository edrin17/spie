<?php 
    $this->assign('title', 'Liste des compétences terminales');
    $this->set('modalTitle','Ajouter une nouvelle compétence intermédiaire');
?>
<?php echo $this->Form->create($competenceTerm); ?>
<div class="row">
    <div class="col-lg-12">       
        <h1>Compétences terminales</h1>
        <div class="col-lg-1 col-lg">
            <br>
            <div class="col-lg-1 col-lg">
            <?php echo $this->element('/Modals/NewEntry'); ?>
        </div>
        </div>
        <div class="col-lg-3 col-lg-offset-8">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Filtrer par référentiel:',
                'onchange' => 'filterCapacitesByReferential()',
                'options' => $referentials,
                'default' => $referential_id
            ]); ?>
        </div>
        <div class="col-lg-10 ">
            <?php echo $this->Form->input('capacite_id', [
                'label' => 'Filtrer par capacité:',
                'onchange' => 'filtreCompetencesTermByCapacites()',
                'options' => $capacites,
                'default' => $capacite_id
            ]); ?>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th> Compétences Terminale </th>
                    <th class="actions">
                        <h3><?= __('Actions') ?></h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listeCompsTerms as $listeCompsTerm): ?> <!--Affiche le contenu de 'capacitess'  -->
                <tr> 
                    <td><?= h($listeCompsTerm->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
                    <td class="actions">
                    <!-- Affiche des urls/boutons et de leurs actions -->
                    <!-- Modal edit -->
                    <?php $this->set('object',$listeCompsTerm); ?>
                    <?php $this->set('action','edit'); ?>
                    <?php $this->set('button','Editer'); ?>
                    <?php $this->set('buttonColor','primary'); ?>
                    <?php $this->set('icon','<i class="fa-solid fa-cog" aria-hidden="true">'); ?>
                    <?php echo $this->element('/Modals/Edit'); ?>
                    <!-- /Modal edit -->
                    <!-- Button delete -->
                    <?php $this->set('object',$listeCompsTerm); ?>
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
</div>
<script type="text/javascript">

    function filtreCompetencesTermByCapacites() {
        var referential_id = document.getElementById("referential-id").value;
        var capacite_id = document.getElementById("capacite-id").value;
        var url = "<?php echo $this->Url->build([
            'controller'=>'CompetencesTerminales','action'=>'index']) ?>" 
            + "?referential_id=" + referential_id + "&capacite_id=" + capacite_id
        window.location = url; 
    }

    function filterCapacitesByReferential() {
    var referential_id = document.getElementById("referential-id").value;

    // Generate the URL using a script block
    var url = "<?php echo $this->Url->build([
            'controller' => 'FiltresAjaxes',
            'action' => 'chainedCapacites'
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
    $('#capacite-id').html(response);

    // Call the next function in the sequence
    filtreCompetencesTermByCapacites();
    }
</script>