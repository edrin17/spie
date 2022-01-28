<?php $this->assign('title', 'Liste des rotations'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
    <h1><?= "Liste des Rotations"?></h1>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?= $this->Html->link(__('Ajouter une rotation'), ['action' => 'add', $periode_id]); ?>
    <?= $this->Form->create(); ?>
    <?= $this->Form->input('classe_id', [
        'label' => 'Filtrer par classes',
        'onchange' => 'select_periodes()',
        'options' => $listClasses
    ]); ?>
    <?= $this->Form->input('periode_id', [
        'label' => 'Filtrer par periode',
        'options' => $selectPeriodes,
        'default' => $periode_id
    ]); ?>

    <?= $this->Form->button(__('Filtrer')); ?>
    <?= $this->Form->end(); ?>

    <table class="table">
        <thead>
            <tr>
                <th>Classe</th>
                <th>Nom</th>
                <th>Thèmes</th>
                <th>Responsable</th>
                <th class="actions"><h3><?= __('Actions'); ?></h3></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rotations as $rotation): ?> <!--Affiche le contenu de 'periodess'  -->
            <tr style = "background-color:#<?= $rotation->theme->color ?>;" >
                <td><?= $rotation->periode->classe->nom ?></td>
                <td><?= $rotation->fullName?></td>
                <td><?= $rotation->theme->nom ?></td>
                <td><?= $rotation->user->nom ?></td>
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $rotation->id]); ?>
                    <?= $this->Html->link(__('Éditer'), ['action' => 'edit', $rotation->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $rotation->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $rotation->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function select_periodes()
{
    var id = document.getElementById("classe-id").value;
	$.get("<?= $this->Url->build([
        'controller'=>'FiltresAjaxes',
        'action'=>'chainedPeriodes']) ?>"
        + "/?parent_id=" +id, function(resp) {
            $('#periode-id').html(resp);
        });
}
</script>
