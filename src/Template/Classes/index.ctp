
<?php
  $this->assign('title', 'Classes');
  function boolToText($bool) {
    if ($bool == 1) {
      $result = 'Archivée';
    }else {
      $result = "Active";
    }
    return $result;
  }
?>  <!-- Customise le titre de la page -->

<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Classes</h1>
    <!-- Affiche le bouton ajouter un classe -->
    <?php echo $this->Html->link(__('Ajouter une classe'), ['action' => 'add']); ?>
        <thead>
            <tr>
                <th><?php echo 'Nom'; ?></th>
                <th><?php echo 'Etat de la classe' ?></th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($classes as $classe): ?> <!--Affiche le contenu de 'classes'  -->
            <tr>
                <td><?php echo h($classe->nom) ?></td>
                <td><?php echo boolToText($classe->archived) ?></td>
                <td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $classe->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $classe->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $classe->id],['confirm' => __('Etes vous sûr de vouloir supprimer # {0}?', $classe->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
