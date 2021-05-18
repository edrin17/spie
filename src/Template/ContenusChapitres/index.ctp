<?php $this->assign('title', 'Liste des contenus de chapitres'); ?>  <!-- Customise le titre de la page -->
<div class="col-lg-12">
	<table class="table">
		<h1>Liste des Contenus de chapitres</h1>
		<!-- Affiche le bouton ajouter un utilisateur -->
		
		<?php echo $this->Form->create(); ?>
        <?php echo __('Filtres:') ?>
        
		<?php echo $this->Form->input('chapitre_id', [
			'onchange' => 'select_chapitre(this)',
            'options' => $listeChapitres
        ]);?>
		
		<?php echo $this->Form->input('sous_chapitre_id', [
            'onchange' => 'select_souschap(this)',
            'options' => $listeSousChapitres
        ]);?>
        
        <?php echo $this->Form->input('sous_sous_chapitre_id', [
            'label' => 'Sous sous chapitre correspondant dans le référentiel',
            'options' => $listeSousSousChapitres
        ]);?>       		
 
        <?php $optionToutVoir = 1 ?>

		
		<?php echo $this->Form->button(__('Filtrer')); ?>
		<?php echo $this->Form->end(); ?>
		<br>
		<?php echo $this->Html->link(__('Ajouter un contenu de chapitre'), ['action' => 'add']); ?>
		<thead>
			<tr>
				<th> Chapitre </th>
				<th> Sous Chapitre </th>
				<th> Sous Sous Chapitre </th>			
				<th> Contenu </th>
				<th class="actions"><h3><?php echo __('Actions'); ?></th>
			</tr>
		</thead>
		<tbody>
            <?php foreach ($contenusChapitres as $contenusChapitre): ?> <!--Affiche le contenu de 'chapitress'  -->
            <tr> 
				<td><?php echo h($contenusChapitre->sous_sous_chapitre->sous_chapitre->chapitre->NumeNom); ?></td>
				<td><?php echo "S." .$contenusChapitre->sous_sous_chapitre->sous_chapitre->chapitre->numero
						."." .$contenusChapitre->sous_sous_chapitre->sous_chapitre->numero
						." - " .h($contenusChapitre->sous_sous_chapitre->sous_chapitre->nom);
					?>
				</td>
				<td><?php echo "S." .$contenusChapitre->sous_sous_chapitre->sous_chapitre->chapitre->numero
						."." .$contenusChapitre->sous_sous_chapitre->sous_chapitre->numero
						."." .$contenusChapitre->sous_sous_chapitre->numero
						." - " .h($contenusChapitre->sous_sous_chapitre->nom);
					?>
				</td>
				<td><b><?php echo "S." .$contenusChapitre->sous_sous_chapitre->sous_chapitre->chapitre->numero
						."." .$contenusChapitre->sous_sous_chapitre->sous_chapitre->numero
						."." .$contenusChapitre->sous_sous_chapitre->numero
						."." .$contenusChapitre->numero
						." - " .h($contenusChapitre->nom);
					?>
				</b></td>
				<td class="actions">
					<!-- Affiche des urls/boutons et de leurs actions -->
					<p>
						<?php echo $this->Html->link(__('Voir'), ['action' => 'view', $contenusChapitre->id]); ?>
						<?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $contenusChapitre->id]); ?>
						<?php echo $this->Form->postLink(__('Supprimer'),
							['action' => 'delete', $contenusChapitre->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $contenusChapitre->id)]); 
						?>
					</p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>
<script>
function select_chapitre(id)
{
    var id = id.value;
	$.get("<?php echo $this->Url->build([
		'controller'=>'SousSousChapitres',
		'action'=>'listeSousChapitres'])
		."/?optionToutVoir=" .$optionToutVoir; ?>"
		+ "&chapitre_id=" +id, function(resp) {
			$("#sous-chapitre-id").html(resp);
			$("#sous-chapitre-id").change();
		});  
}
function select_souschap(id)
{
    var id = id.value;
	$.get("<?php echo $this->Url->build([
					'controller'=>'ContenusChapitres',
					'action'=>'listeSousSousChapitres'])
					."/?optionToutVoir=" .$optionToutVoir; ?>"
					+ "&sous_chapitre_id=" +id, 
                    function(resp) {
                        $("#sous-sous-chapitre-id").html(resp);
                    }
    );    
}
</script>   


