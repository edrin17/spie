<?php $this->assign('title', 'Liste des compétences terminales'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">       
        <h1>Compétences terminales</h1>
        <div class="col-lg-1 col-lg">
            <br>
            <?php echo $this->Html->link('Ajouter une compétence terminale', 
                [
                    'action' => 'add',
                    "referential_id" => $referential_id,
                    "capacite_id" => $capacite_id
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
                    <p>
                        <?= $this->Html->link(
                            __('Editer'),['action' => 'edit', $listeCompsTerm->id, "referential_id" => $referential_id,
                            "capacite_id" => $capacite_id]
                        )?>
                        <?= $this->Form->postLink(
                            __('Supprimer'),['action' => 'delete', $listeCompsTerm->id, "referential_id" => $referential_id,
                            "capacite_id" => $capacite_id],
                            ['confirm' => __(
                                'Etes vous sur de vouloirs supprimer: {0}?', $listeCompsTerm->fullName
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
        $.when(
            $.get("<?php echo $this->Url->build([
            'controller'=>'FiltresAjaxes',
            'action'=>'chainedCapacites'])
            ."/?referential_id="; ?>"
            + referential_id, function(resp) {
                $('#capacite-id').html(resp);
            })
        ).then (function filtreCompetencesTermByCapacites() {
            var referential_id = document.getElementById("referential-id").value;
            var capacite_id = document.getElementById("capacite-id").value;
            var url = "<?php echo $this->Url->build([
                'controller'=>'CompetencesTerminales','action'=>'index']) ?>" 
                + "?referential_id=" + referential_id + "&capacite_id=" + capacite_id
            window.location = url; }
        );
    }
</script>