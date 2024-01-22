<?php
    $this->assign('title', 'Savoir');
    $this->set('modalTitle','Ajouter un nouveau savoir');
?> 
<?php echo $this->Form->create($savoir); ?>
<div class="row">
    <div class="col-lg-12">
        <table class="table">
    <h1>Savoirs</h1>
    <div class="col-lg-1 col-lg">
        <br>
        <div class="col-lg-1 col-lg">
            <?php echo $this->element('/Modals/NewEntry'); ?>
        </div>
    </div>
    <div class="col-lg-3 col-lg-offset-8">
        <?php echo $this->Form->input('referential_id', [
            'label' => 'Filtrer par référentiel:',
            'onchange' => 'filtreSavoirsByReferentials()',
            'options' => $referentials,
            'default' => $referential_id
        ]); ?>
    </div>
    <!-- Affiche le paginator -->
        <thead>
            <tr>
                <th>Nom du savoir</th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($savoirs as $savoir): ?> <!--Affiche le contenu de 'activites'  -->
                <tr> 
                    <td><?= h($savoir->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
                    <td class="actions">
                    <!-- Affiche des urls/boutons et de leurs actions -->
                    <!-- Modal edit -->
                    <?php $this->set('object',$savoir); ?>
                    <?php $this->set('action','edit'); ?>
                    <?php $this->set('button','Editer'); ?>
                    <?php $this->set('buttonColor','primary'); ?>
                    <?php $this->set('icon','<i class="fa-solid fa-cog" aria-hidden="true">'); ?>
                    <?php echo $this->element('/Modals/Edit'); ?>
                    <!-- /Modal edit -->
                    <!-- Button delete -->
                    <?php $this->set('object',$savoir); ?>
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
<script>

function filtreSavoirsByReferentials()
{
    var id = document.getElementById("referential-id").value;
    var url = "<?php echo $this->Url->build([
        'controller'=>'Savoirs','action'=>'index']) ?>" 
        + "/?referential_id=" + id
	window.location = url;
}

</script>
