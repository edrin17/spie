<?php $this->assign('title', 'Liste des compétences intermediaires'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">       
        <h1>Compétences intermédiaires</h1>
        <div class="col-lg-1 col-lg">
            <br>
            <?php echo $this->Html->link('Ajouter une compétence intermédiaire', 
                [
                    'action' => 'add',
                    'referential_id' => $referential_id,
                    'capacite_id' => $capacite_id,
                    'competence_terminale_id' => $competences_terminale_id
                ],
                ['class' => "btn btn-info",'type' => 'button' ]
            ); ?>
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
        <div class="col-lg-10 ">
            <?php echo $this->Form->input('competences_terminale_id', [
                'label' => 'Filtrer par compétence terminale:',
                'onchange' => 'filtreCompetencesInterByCompTerm()',
                'options' => $competencesTerminales,
                'default' => $competences_terminale_id
            ]); ?>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th> Compétences Intermédaire </th>
                    <th class="actions">
                        <h3><?= __('Actions') ?></h3>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($competencesIntermediaires as $competenceIntermediaire): ?> <!--Affiche le contenu de 'capacitess'  -->
                <tr> 
                    <td><?= h($competenceIntermediaire->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
                    <td class="actions">
                    <!-- Affiche des urls/boutons et de leurs actions -->
                    <p>
                        <?= $this->Html->link(
                            __('Editer'),['action' => 'edit', $competenceIntermediaire->id, "referential_id" => $referential_id,
                            "capacite_id" => $capacite_id]
                        )?>
                        <?= $this->Form->postLink(
                            __('Supprimer'),['action' => 'delete', $competenceIntermediaire->id, "referential_id" => $referential_id,
                            "capacite_id" => $capacite_id],
                            ['confirm' => __(
                                'Etes vous sur de vouloirs supprimer: {0}?', $competenceIntermediaire->fullName
                            )]
                        )?>
                    </p>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>       
        </table>
    </div>
</div>
<script type="text/javascript">

    function filtreCompetencesInterByCompTerm() {
        var referential_id = document.getElementById("referential-id").value;
        var capacite_id = document.getElementById("capacite-id").value;
        var competences_terminale_id = document.getElementById("competences-terminale-id").value;
        var url = "<?php echo $this->Url->build([
            'controller'=>'CompetencesIntermediaires','action'=>'index']) ?>" 
            + "?referential_id=" + referential_id + "&capacite_id="
            + capacite_id + "&competences_terminale_id=" + competences_terminale_id
        window.location = url;
    }

    function filtreCompetencesTermByCapacites() {
        var referential_id = document.getElementById("referential-id").value;
        var capacite_id = document.getElementById("capacite-id").value;
        $.when(
            $.get("<?php echo $this->Url->build([
                'controller'=>'FiltresAjaxes',
                'action'=>'chainedCompetencesTerminales'])
                ."/?referential_id="; ?>"
                + referential_id + "&capacite_id=" + capacite_id, function(resp) {
                    $('#competences-terminale-id').html(resp);
                }
            )
        ).then (filtreCompetencesInterByCompTerm());
    }

    function filterCapacitesByReferential() {
        var referential_id = document.getElementById("referential-id").value;
        $.when(
            $.get("<?php echo $this->Url->build([
            'controller'=>'FiltresAjaxes',
            'action'=>'chainedCapacites'])
            ."/?referential_id="; ?>"
            + referential_id, function(resp) {
                $('#capacite-id').html(resp);
            })
        ).then (filtreCompetencesTermByCapacites());
    }
</script>
