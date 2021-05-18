<?php $this->assign('title', 'Choix des élèves'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des élèves pour le suivi</h1>
        <tbody>
            <?php foreach ($eleves as $eleve): ?> <!--Affiche le contenu de 'activitess'  -->
            <tr> 
				<td class="actions">
					<?php echo $this->Html->link(__($eleve->nom." ".$eleve->prenom), ['action' => 'suivi', $eleve->id]); ?>
				</td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>
