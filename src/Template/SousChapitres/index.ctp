<?php 
    $this->assign('title', 'Liste des sous-chapitres');
    $this->set('modalTitle','Ajouter un nouveau sous-chapitre');
    $this->set('niveauxTaxos',$niveauxTaxos);
?> 
<?php echo $this->Form->create($sousChapitre); ?>
<div class="row">
    <div class="col-lg-12">       
        <h1>Sous chapitres</h1>
        <div class="col-lg-1 col-lg">
            <?php echo $this->element('/Modals/NewSousChapitre'); ?>
        </div>
        <div class="col-lg-3 col-lg-offset-8">
            <?php echo $this->Form->input('referential_id', [
                'label' => 'Filtrer par référentiel:',
                'onchange' => 'filterSavoirsByReferential()',
                'options' => $referentials,
                'default' => $referential_id
            ]); ?>
        </div>
        <div class="col-lg-10 ">
            <?php echo $this->Form->input('savoir_id', [
                'label' => 'Filtrer par savoir:',
                'onchange' => 'filtreChapitresBySavoir()',
                'options' => $savoirs,
                'default' => $savoir_id
            ]); ?>
        </div>
        <div class="col-lg-10 ">
            <?php echo $this->Form->input('chapitre_id', [
                'label' => 'Filtrer par chapitre:',
                'onchange' => 'filtreSousChapitreByChapitre()',
                'options' => $chapitres,
                'default' => $chapitre_id
            ]); ?>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th> Sous Chapitres </th>
                    <th class="actions">
                        <h3><?= __('Actions') ?></h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sousChapitres as $sousChapitre): ?> <!--Affiche le contenu de 'savoirss'  -->
                <tr> 
                    <td><?= h($sousChapitre->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
                    <td class="actions">
                    <!-- Affiche des urls/boutons et de leurs actions -->
                    <!-- Modal edit -->
                    <?php $this->set('object',$sousChapitre); ?>
                    <?php $this->set('action','edit'); ?>
                    <?php $this->set('button','Editer'); ?>
                    <?php $this->set('buttonColor','primary'); ?>
                    <?php $this->set('icon','<i class="fa-solid fa-cog" aria-hidden="true">'); ?>
                    <?php echo $this->element('/Modals/Edit'); ?>
                    <!-- /Modal edit -->
                    <!-- Button delete -->
                    <?php $this->set('object',$sousChapitre); ?>
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

    function filtreSousChapitreByChapitre() {
        var referential_id = document.getElementById("referential-id").value;
        var savoir_id = document.getElementById("savoir-id").value;
        var chapitre_id = document.getElementById("chapitre-id").value;
        var url = "<?php echo $this->Url->build([
            'controller'=>'SousChapitres','action'=>'index']) ?>" 
            + "?referential_id=" + referential_id + "&savoir_id="
            + savoir_id + "&chapitre_id=" + chapitre_id
        window.location = url;
    }

    function filtreChapitresBySavoir() {
        var referential_id = document.getElementById("referential-id").value;
        var savoir_id = document.getElementById("savoir-id").value;

        // Generate the URL using a script block
        var url = "<?php echo $this->Url->build([
                'controller' => 'FiltresAjaxes',
                'action' => 'chainedSavoirs'
            ]); ?>/?referential_id=" + referential_id + "&savoir_id=" + savoir_id;

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
        $('#competences-terminale-id').html(response);

        // Call the next function in the sequence
        filtreSousChapitreByChapitre();
    }

    function filterSavoirsByReferential() {
        var referential_id = document.getElementById("referential-id").value;

        // Generate the URL using a script block
        var url = "<?php echo $this->Url->build([
                'controller' => 'FiltresAjaxes',
                'action' => 'chainedSavoirs'
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
        $('#savoir-id').html(response);

        // Call the next function in the sequence
        filtreChapitresBySavoir();
    }

</script>
