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
			<tr>				
				<?php foreach ($evaluations as $evaluation) :?>
					<?php if (($competence->id == $evaluation->travaux_pratiques_objectifs_peda->objectifs_peda->competences_intermediaire->id)
						and ($tableauEval[$competence->id]['displayed'] == false)) :?>
					<?php $tableauEval[$competence->id]['displayed'] = true; ?> 
					<td><?php echo h("C.".$competence->competences_terminale->capacite->numero.
						".".$competence->competences_terminale->numero.
						".".$competence->numero.": ".$competence->nom); ?></td>
					<td><?php echo h($tableauEval[$competence->id]['nbEvals']); ?></td>
					<td><?php echo h($tableauEval[$competence->id]['nbEvalsPfmp']); ?></td>
					<td><?php echo h($tableauEval[$competence->id]['valeurChaine']); ?></td>
					<?php endif; ?>
				<?php endforeach; ?>
			</tr>
			<?php endforeach; ?>
        </tbody>       
    </table>
</div>
</div>
