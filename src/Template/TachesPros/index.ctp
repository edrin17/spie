<?php 
    $this->assign('title', 'Liste des tâches professionnelles');
    $this->set('modalTitle','Ajouter une nouvelle tâche');
    $this->set('niveaux',$autonomies);
?>
<?php echo $this->Form->create($tache); ?>
<div class="row">
    <div class="col-lg-12">       
        <h1>Tâches professionnelles</h1>
        <div class="col-lg-1 col-lg">
            <br>
            <div class="col-lg-1 col-lg">
            <?php echo $this->element('/Modals/NewTache'); ?>
        </div>
        </div>
        <div class="col-lg-3 col-lg-offset-8">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Filtrer par référentiel:',
                'onchange' => 'filtreActivitesByReferential()',
                'options' => $referentials,
                'default' => $referential_id
            ]); ?>
        </div>
        <div class="col-lg-10 ">
            <?php echo $this->Form->input('activite_id', [
                'label' => 'Filtrer par activité:',
                'onchange' => 'filtreTachesProsByActivites()',
                'options' => $activites,
                'default' => $activite_id
            ]); ?>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th> Tâches professionnelles </th>
                    <th class="actions">
                        <h3><?= __('Actions') ?></h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listeTachesPros as $listeTachesPro): ?> <!--Affiche le contenu de 'activitess'  -->
                <tr> 
                    <td><?= h($listeTachesPro->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
                    <td class="actions">
                    <!-- Affiche des urls/boutons et de leurs actions -->
                    <!-- Modal edit -->
                    <?php $this->set('tache',$listeTachesPro); ?>
                    <?php $this->set('action','edit'); ?>
                    <?php $this->set('button','Editer'); ?>
                    <?php $this->set('buttonColor','primary'); ?>
                    <?php $this->set('icon','<i class="fa-solid fa-cog" aria-hidden="true">'); ?>
                    <?php echo $this->element('/Modals/EditTache'); ?>
                    <!-- /Modal edit -->
                    <!-- Button delete -->
                    <?php $this->set('object',$listeTachesPro); ?>
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

    function filtreTachesProsByActivites() {
        var referential_id = document.getElementById("referential-id").value;
        var activite_id = document.getElementById("activite-id").value;
        var url = "<?php echo $this->Url->build([
            'controller'=>'TachesPros','action'=>'index']) ?>" 
            + "?referential_id=" + referential_id + "&activite_id=" + activite_id
        window.location = url; 
    }

    function filtreActivitesByReferential() {
    var referential_id = document.getElementById("referential-id").value;

    // Generate the URL using a script block
    var url = "<?php echo $this->Url->build([
            'controller' => 'FiltresAjaxes',
            'action' => 'chainedActivitesByReferential'
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
    $('#activite-id').html(response);

    // Call the next function in the sequence
    filtreTachesProsByActivites();
    }
</script>

