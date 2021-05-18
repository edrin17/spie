<?php $this->assign('title', 'Activités'); ?>  <!-- Customise le titre de la page -->

<h1>Activités</h1>
<table id ="tableau" class="display">
        <thead>
            <tr>
                <th> Numéro </th> <!-- Utilise Helper::Paginator pour crée un hyper lien qui classe si on clique dessus -->
                <th> Nom de l'activité </th>
                <th class="actions"><h3><?= __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($activites as $activite): ?> <!--Affiche le contenu de 'activites'  -->
            <tr> 
                <td><?= "A.".h($activite->numero) ?></td>
                <td><?= h($activite->nom) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(__('Voir'), ['action' => 'view', $activite->id]); ?>
                    <?= $this->Html->link(__('Editer'), ['action' => 'edit', $activite->id]); ?>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $activite->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $activite->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
</table>
<!-- Affiche le bouton ajouter un activite -->
<?= $this->Html->link(__('Ajouter une activité'), ['action' => 'add']); ?>

<script>
$(document).ready(function() {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
        }
    });
} );
</script>
