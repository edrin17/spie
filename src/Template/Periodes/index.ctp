<?php $this->assign('title', 'Périodes'); ?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-2">
        <h1>Périodes</h1>
    </div>
    <div class="col-lg-1 col-lg-offset-5">
        <br>
        <?php echo $this->Html->link('Ajouter une période', ['action' => 'add'],
            ['class' => "btn btn-success",'type' => 'button' ]
        ); ?>
    </div>
    <div class="col-lg-2 col-lg-offset-1">
        <?php echo $this->Form->input('referential_id', [
            'label' => 'Filtrer par référentiel:',
            'onchange' => 'filtreByReferential()',
            'options' => $referentials,
            'default' => $referential_id
        ]); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table" id ="tableau">
            <thead>
                <tr>
                    <th>Numéros</th>
                    <th>Classes</th>
                    <th>Référentiels</th>
                    <th class="actions"><h3><?php echo __('Actions'); ?></h3></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($periodes as $periode): ?> <!--Affiche le contenu de 'periodes'  -->
                <tr>
                    <td><?php echo"P.".h($periode->numero) ?></td>
                    <td><?php echo h($periode->classe->nom) ?></td>
                    <td><?php echo h($periode->referential->nom) ?></td>
                    <td class="actions">
                    <!-- Affiche des urls/boutons et de leurs actions -->
                    <p>
                        <?php echo $this->Html->link(__('Éditer'), ['action' => 'edit', $periode->id]); ?>
                        <?php echo $this->Form->postLink(__('Supprimer'),
                            ['action' => 'delete', $periode->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $periode->id)]); ?>
                    </p>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/French.json"
        }
    });
} );

function filtreByReferential()
{
    var id = document.getElementById("referential-id").value;
    var url = "<?php echo $this->Url->build(['controller'=>'Periodes','action'=>'index']) ?>" + "/?referential_id=" + id
	window.location = url;
}

</script>
