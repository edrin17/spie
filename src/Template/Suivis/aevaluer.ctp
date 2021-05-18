<?php $this->assign('title', "Suivi de l'élève ".$eleve->nom." ".$eleve->prenom); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">		
	<table class="table">
    <h1><?php echo "Suivi de l'élève" ?> </h1>	
	<td><?php echo $this->Html->link(__("Voir toutes les évaluations"), ['action' => 'suivi', $eleve->id]); ?></td>
	<td><?php echo $this->Html->link(__("Voir ce qui est évalué"), ['action' => 'dejaevalue', $eleve->id]); ?></td>	
	<td><?php echo $this->Html->link(__("Voir ce qui reste à évaluer"), ['action' => 'aevaluer', $eleve->id]); ?></td>	
		<tbody> 	
			<tr>
				<th>Compétences</th>
				<th>Évaluations formatives</th>
				<th>Évaluations en pfmp</th>
				<th>Acquisition</th>
			</tr>    
			<?php foreach ($competences as $competence): ?>
			<?php $evaluee = false; ?>
			<tr>				
				<?php foreach ($evaluations as $evaluation) :?>
					<?php if ($competence->id == $evaluation->travaux_pratiques_objectifs_peda->objectifs_peda->competences_intermediaire->id ) :?> 
					<?php $evaluee = true ?>
					<?php endif; ?>
				<?php endforeach; ?>
				<?php if ($evaluee == false) :?>
					<td><?php echo h("C.".$competence->competences_terminale->capacite->numero.
						".".$competence->competences_terminale->numero.
						".".$competence->numero.": ".$competence->nom); ?></td>
					<td >0</td>
					<td >0</td>
					<td >Non Vu</td>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
        </tbody>       
    </table>
</div>
</div>
