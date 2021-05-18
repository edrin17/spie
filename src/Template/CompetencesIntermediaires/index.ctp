<?php $this->assign('title', 'Liste des Compétences Intermédiaires'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1>Liste des Compétences</h1>
		<?php echo $this->Form->create(); ?>
        <?php echo __('Filtre:'); ?>
        <?php echo $this->Form->input('capacite_id', [
            'onchange' => 'select_capacites(this)',
            'options' => $listeCapacites
            ]);?>
        
        <?php echo $this->Form->input('competences_terminale_id', [
        'options' => $listeCompetencesTerminales
        ]);?>
        <?php $optionToutVoir = 1 ;?>
		<?php echo $this->Form->button(__('Filtrer')); ?>
		<?php echo $this->Form->end(); ?>
		<br>
    <!-- Affiche le bouton ajouter un utilisateur -->
    <?php echo $this->Html->link(__('Ajouter une compétence'), ['action' => 'add']); ?>
		<thead>
            <tr>
                <th> Capacités </th>
                <th> Compétences Terminales </th>
                <th> Compétences Intermédiaires </th>
                <th class="actions"><h3><?php echo __('Actions'); ?></h3></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($competencesIntermediaires as $competencesIntermediaire): ?> <!--Affiche le contenu de 'competences'  -->
            <?php //debug($competencesIntermediaire);die; ?>
            <tr> 
                <td><?php echo h("C.".$competencesIntermediaire->competences_terminale->capacite->numero.": ".
					$competencesIntermediaire->competences_terminale->capacite->nom); ?></td>
                <td><?php echo h("C.".$competencesIntermediaire->competences_terminale->capacite->numero.
					"." .$competencesIntermediaire->competences_terminale->numero.
					": ".$competencesIntermediaire->competences_terminale->nom); ?></td>
				<td><?php echo h("C.".$competencesIntermediaire->competences_terminale->capacite->numero.
					"." .$competencesIntermediaire->competences_terminale->numero.
					"." .$competencesIntermediaire->numero.
					": ".$competencesIntermediaire->nom); ?></td>
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $competencesIntermediaire->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $competencesIntermediaire->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $competencesIntermediaire->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $competencesIntermediaire->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>
<script>
function select_capacites(id)
{
    var id = id.value;
	$.get("<?php echo $this->Url->build([
					'controller'=>'FiltresAjaxes',
					'action'=>'chainedCompsTerms'])
					."/?optionToutVoir=" .$optionToutVoir; ?>"
					+ "&parent_id=" +id, function(resp) {
          $('#competences-terminale-id').html(resp);
     });
    
}
</script>
