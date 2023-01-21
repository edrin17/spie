<?php $this->assign('title', 'Savoirs'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-2">
        <h1>Savoirs</h1>
    </div>
    <div class="col-lg-3 col-lg-offset-2">
        <?php echo $this->Html->link(
            'Ajouter un savoir',
            ['action' => 'add', '?' => ['referential_id' => $referential_id]],
            ['class' => "btn btn-info", 'role' => 'button']
        ); ?>
    </div>
    <div class="col-lg-3 ">
        <?php echo $this->Form->input('referential_id', [
            'label' => 'Filtrer par référentiel:',
            'onchange' => 'filtreSavoirsByReferentials()',
            'options' => $referentials,
            'default' => $referential_id
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
    <table id ="tableau" class="table table-hover">
        <thead>
            <tr>
                <th> Nom </th>
                <th> Référentiel</th>
                <th class="actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($savoirs as $savoir): ?> <!--Affiche le contenu de 'savoirs'  -->
            <tr>
                <td><?php echo h($savoir->fullName) ?></td>
                <td><?php echo h($savoir->referential->name) ?></td>
                <td class="actions">
                    <div class="btn-group" role="group">
                        <?php echo $this->Html->link('<i class="fa-solid fa-cog btn btn-default" aria-hidden="true"></i>', [
                            'controller' => 'Savoirs',
                            'action' => 'edit',
                            $savoir->id,
                        ],['role'=>'button', 'escape' => false]) ?>
                        <?php echo $this->Form->postButton(
                            '<i class="fa-solid fa-trash" aria-hidden="true"></i>',
                            ['controller' => 'savoirs', 'action' => 'delete', $savoir->id, '?' => [
                                'savoir' => $savoir->savoir_id]],
                            ['confirm' => 'Etes-vous sûr de voulour supprimer le TP: ' . $savoir->name . '?', 'escape' => false]
                        ); ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>

function filtreSavoirsByReferentials()
{
    var id = document.getElementById("referential-id").value;
    var url = "<?php echo $this->Url->build(['controller'=>'Savoirs','action'=>'index']) ?>" + "/?referential_id=" + id
	window.location = url;
}

</script>