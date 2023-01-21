<?php $this->assign('title', 'Liste des rotations'); ?>  <!-- Customise le titre de la page -->
<div class="container-fuild">
    <div class="row">
        <div class="col-lg-4">
            <h1>Liste des Rotations</h1>
        </div>
        <div class="col-lg-1 col-lg-offset-6">
            <br>
            <?php echo $this->Html->link('Ajouter une rotation', ['action' => 'add', $periode_id],
                ['class' => "btn btn-success",'type' => 'button' ]
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?php echo $this->Form->input('progression_id', [
                'label' => 'Filter par progression:',
                'onchange' => 'filter()',
                'default' => $progression_id
            ]); ?>
        </div>
        <div class="col-lg-3">
            <?php echo $this->Form->input('periode_id', [
                'label' => 'Filtrer par periode',
                'onchange' => 'filter()',
                'default' => $periode_id
            ]); ?>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Thèmes</th>
                <th class="actions"><h3><?php echo __('Actions'); ?></h3></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rotations as $rotation): ?> <!--Affiche le contenu de 'periodess'  -->
            <tr style = "background-color:#<?php echo $rotation->theme->color ?>;" >
                <td><?php echo $rotation->fullName?></td>
                <td><?php echo $rotation->theme->nom ?></td>
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $rotation->id]); ?>
                    <?php echo $this->Html->link(__('Éditer'), ['action' => 'edit', $rotation->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $rotation->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $rotation->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
function filter()
{
    var $progression_id = document.getElementById("progression-id").value;
    var $periode_id = document.getElementById("periode-id").value;
    var url = "<?php echo $this->Url->build(['controller'=>'Rotations','action'=>'index']) ?>" +
        "/?progression_id=" + $progression_id +
        "&periode_id=" + $periode_id;
	window.location = url;
}
</script>
