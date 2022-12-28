<?php $this->assign('title', 'Périodes'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table" id ="tableau" class="display">
    <h1>Périodes</h1>
    <!-- Affiche le bouton ajouter un periode -->
    <?php echo $this->Html->link(__('Ajouter une période'), ['action' => 'add']); ?>
        <thead>
            <tr>
                <th>Numéros</th>
                <th>Classes</th>
                <th>Référentiels</th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
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
<script>
$(document).ready(function() {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/French.json"
        }
    });
} );
</script>
