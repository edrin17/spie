
<?php $this->assign('title', 'Liste des compétences terminales'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des compétences terminales</h1>
        <thead>
            <tr>
                <th> Capacités </th>
                <th> Compétences Terminale </th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($competences as $competence): ?> <!--Affiche le contenu de 'capacitess'  -->
            <tr> 
                <td><?= h("C.".$competence->capacite->numero.": " .$competence->capacite->nom); ?></td>
                <td><?= h("C.".$competence->capacite->numero ."." .$competence->numero .": ".$competence->nom); ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $competence->id]); ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $competence->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $competence->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $competence->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?= $this->Html->link(__('Ajouter une compétence'), ['action' => 'add']); ?> 
</div>

