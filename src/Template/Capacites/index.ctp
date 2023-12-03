<?php $this->assign('title', 'Capacités'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
        <table class="table">
    <h1>Capacités</h1>
    <div class="col-lg-1 col-lg">
        <br>
        <?php echo $this->Html->link('Ajouter une capacité',
            ['action' => 'add', "referential_id" => $referential_id],
            ['class' => "btn btn-info",'type' => 'button']          
        ); ?>
    </div>
    <div class="col-lg-3 col-lg-offset-8">
        <?php echo $this->Form->input('referential_id', [
            'label' => 'Filtrer par référentiel:',
            'onchange' => 'filtreCapacitesByReferentials()',
            'options' => $referentials,
            'default' => $referential_id
        ]); ?>
    </div>
    <!-- Affiche le paginator -->
        <thead>
            <tr>
                <th>Nom de la capacité</th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($capacites as $capacite): ?> <!--Affiche le contenu de 'capacites'  -->
            <tr> 
                <td><?php echo h($capacite->fullName) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $capacite->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $capacite->id],['confirm' => __('Etes vous sur de vouloirs supprimer: {0}?', $capacite->nom)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>
<script>

function filtreCapacitesByReferentials()
{
    var id = document.getElementById("referential-id").value;
    var url = "<?php echo $this->Url->build([
        'controller'=>'Capacites','action'=>'index']) ?>" 
        + "/?referential_id=" + id
	window.location = url;
}

</script>
