<?php $this->assign('title', 'Liste des documents donnés'); ?>  <!-- Customise le titre de la page -->
<div class="row">
  <div class="col-lg-12">
  <table class="table">
    <h1>Liste des Docs</h1>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?php echo $this->Html->link(__('Ajouter un document'), ['action' => 'add']); ?>
    <tr>
        <th> Nom </th>
        <th class="actions"><h3><?php echo __('Actions'); ?></th>
    </tr>
    </thead>
    <tbody>
      <?php foreach ($givenCourses as $givenCourse): ?>
      <tr>
    		<td><?php echo h($givenCourse->name); ?></td>
    		<td class="actions">
          <!-- Affiche des urls/boutons et de leurs actions -->
          <p>
              <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $givenCourse->id]); ?>
              <?php echo $this->Html->link(__('Associer'), ['action' => 'classSelect', $givenCourse->id]); ?>
              <?php echo $this->Form->postLink(__('Supprimer'),
                  ['action' => 'delete', $givenCourse->id],['confirm' => __('Etes vous sur de vouloirs supprimer "'.$givenCourse->name.'"?' , $givenCourse->id)]); ?>
          </p>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
