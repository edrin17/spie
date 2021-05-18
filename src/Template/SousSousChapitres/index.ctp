<?php $this->assign('title', 'Liste des Sous-sous-chapitres'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
        <table class="table">
		<h1>Liste des Sous-sous-chapitres</h1>
		
		<?php echo $this->Form->create(); ?>
        <?php echo __('Filter:') ?>
        
        <?php echo $this->Form->input('chapitre_id', [
            'onchange' => 'select_cat(this)',
            'options' => $listeChapitres
            ]);?>
        
        <?php echo $this->Form->input('sous_chapitre_id', [
            'options' => $listeSousChapitres
        ]);?>
        
        <?php $optionToutVoir = 1 ?>
		<?php echo $this->Form->button(__('Filtrer')); ?>
		<?php echo $this->Form->end(); ?>
		<br>
		<?php echo $this->Html->link(__('Ajouter un sous-sous chapitre'), ['action' => 'add']); ?>
        <thead>
            <tr>
                <th> Chapitres </th>
                <th> Sous-chapitres </th>
                <th> Sous-sous-chapitres </th>
                <th class="actions"><h3><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sousSousChapitres as $sousSousChapitre): ?> <!--Affiche le contenu de 'competences'  -->
            <tr> 
                <td><?php echo h($sousSousChapitre->sous_chapitre->chapitre->NumeNom); ?></td>
                <td><?php echo h("S.".$sousSousChapitre->sous_chapitre->chapitre->numero.
					"." .$sousSousChapitre->sous_chapitre->numero.
					" - ".$sousSousChapitre->sous_chapitre->nom); ?></td>
				<td><b><?php echo h("S.".$sousSousChapitre->sous_chapitre->chapitre->numero.
					"." .$sousSousChapitre->sous_chapitre->numero.
					"." .$sousSousChapitre->numero.
					" - ".$sousSousChapitre->nom); ?></b></td>
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?php echo $this->Html->link(__('Voir'), ['action' => 'view', $sousSousChapitre->id]); ?>
                    <?php echo $this->Html->link(__('Editer'), ['action' => 'edit', $sousSousChapitre->id]); ?>
                    <?php echo $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $sousSousChapitre->id],['confirm' => __('Etes vous sur de vouloirs supprimer # {0}?', $sousSousChapitre->id)]); ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
    <!-- Affiche le bouton ajouter un utilisateur -->
 <script>
function select_cat(id)
{
    var id = id.value;
	$.get("<?php echo $this->Url->build([
					'controller'=>'SousSousChapitres',
					'action'=>'listeSousChapitres'])
					."/?optionToutVoir=" .$optionToutVoir; ?>"
					+ "&chapitre_id=" +id, function(resp) {
          $('#sous-chapitre-id').html(resp);
     });
    
}
</script>
</div>

