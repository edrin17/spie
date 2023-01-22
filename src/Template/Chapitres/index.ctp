<?php $this->assign('title', 'Chapitres'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-2">
        <h1>Chapitres</h1>
    </div>
    <div class="col-lg-1 col-lg-offset-3">
        <br>
        <?php echo $this->Html->link('Ajouter un chapitre', ['action' => 'add',$savoir_id],
            ['class' => "btn btn-info",'type' => 'button' ]
        ); ?>
    </div>
    <div class="col-lg-5 col-lg-offset-1">
        <?php echo $this->Form->input('savoir_id', [
            'label' => 'Filtrer par savoir:',
            'onchange' => 'filtreChapitresBySavoirs()',
            'options' => $savoirs,
            'default' => $savoir_id
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
    <table id ="tableau" class="table table-hover">
        <thead>
            <tr>
                <th> Chapitre </th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($chapitres as $chapitre): ?> <!--Affiche le contenu de 'chapitres'  -->
            <tr>
                <td><?php echo $chapitre->num. '.'. h($chapitre->name) ?></td>
                <td class="actions">
                    <div class="btn-group" role="group">
                        <?php echo $this->Html->link('<i class="fa-solid fa-cog btn btn-default" aria-hidden="true"></i>', [
                            'controller' => 'Chapitres',
                            'action' => 'edit',
                            $chapitre->id,
                        ],['role'=>'button', 'escape' => false]) ?>
                        <div class="btn-group" role="group">
                        <?php echo $this->Html->link('<i class="fa-solid fa-plus btn btn-default" aria-hidden="true"></i>', [
                            'controller' => 'Chapitres',
                            'action' => 'addChild',
                            '?' =>['chapitre_id' => $chapitre->id,'savoir_id' => $savoir_id]
                        ],['role'=>'button', 'escape' => false]) ?>
                        <?php echo $this->Form->postButton('<i class="fa-solid fa-trash" aria-hidden="true"></i>',[
                            'controller' => 'chapitres', 'action' => 'delete', $chapitre->id, '?' => [
                                'chapitre' => $chapitre->chapitre_id]],
                            ['confirm' => 'Etes-vous sûr de voulour supprimer le chapitre: ' . $chapitre->name . '?', 'escape' => false]
                        ); ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>

function filtreChapitresBySavoirs()
{
    var id = document.getElementById("savoir-id").value;
    var url = "<?php echo $this->Url->build(['controller'=>'Chapitres','action'=>'index']) ?>" + "/?savoir_id=" + id
	window.location = url;
}

</script>