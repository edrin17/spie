<?php
    $this->assign('title', 'Niveau Taxonomique');
    $this->set('modalTitle','Ajouter une nouvelle activité');
?> 
<?php echo $this->Form->create($niveauxTaxo); ?>
<div class="row">
    <div class="col-lg-12">
        <table class="table">
        <h1>Niveau Taxonomiques</h1>
        <div class="col-lg-1 col-lg">
            <br>
            <div class="col-lg-1 col-lg">
                <?php echo $this->element('/Modals/NewEntry'); ?>
            </div>
        </div>
        <thead>
            <tr>
                <th>Nom de l'activité</th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($niveauxTaxos as $niveauxTaxo): ?> <!--Affiche le contenu de 'niveauxTaxos'  -->
                <tr> 
                    <td><?php echo h($niveauxTaxo->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
                    <td class="actions">
                    <!-- Affiche des urls/boutons et de leurs actions -->
                    <!-- Modal edit -->
                    <?php $this->set('object',$niveauxTaxo); ?>
                    <?php $this->set('action','edit'); ?>
                    <?php $this->set('button','Editer'); ?>
                    <?php $this->set('buttonColor','primary'); ?>
                    <?php $this->set('icon','<i class="fa-solid fa-cog" aria-hidden="true">'); ?>
                    <?php echo $this->element('/Modals/Edit'); ?>
                    <!-- /Modal edit -->
                    <!-- Button delete -->
                    <?php $this->set('object',$niveauxTaxo); ?>
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
