<?php $this->assign('title', 'Choix de la classe'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des classe pour le suivi</h1>
        <tbody>
            <?php foreach ($classes as $classe): ?> <!--Affiche le contenu de 'activitess'  -->
            <tr> 
				<td class="actions">
					<?php echo $this->Html->link(__($classe->nom), ['action' => 'view', $classe->id]); ?>
				</td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>
