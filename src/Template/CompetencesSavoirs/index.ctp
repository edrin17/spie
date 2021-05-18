<?php $this->assign('title', 'Compétences X Savoirs'); ?>  <!-- Customise le titre de la page -->
<table class="table">
    <h1> Compétences X Savoirs </h1>
    <thead>
        <tr>
			<th></th>
			<?php foreach ($listeCompsTerms as $listeCompsTerm): ?>
            <th><?php echo "C".$listeCompsTerm->capacite->numero 
				."." .$listeCompsTerm->numero ." - "
				.h($listeCompsTerm->nom); ?></th>
            <?php endforeach; ?> 
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listeSousChapitres as $listeSousChapitre): ?>
        <tr> 
			<td><?php echo "S".$listeSousChapitre->chapitre->numero 
				."." .$listeSousChapitre->numero ." - "
				.h($listeSousChapitre->nom); ?></td>			
			<?php foreach ($listeCompsTerms as $listeCompsTerm): ?>				
				<?php if ($tableau[$listeCompsTerm->id][$listeSousChapitre->id]) : ?>
				
					<td bgcolor="green">
						<?php echo $this->Form->postLink(__('Supprimer'),
							['action' => 'delete', $tableau[$listeCompsTerm->id][$listeSousChapitre->id] ],
							['confirm' => __('Etes vous sur de vouloirs supprimer cette association ?')]
						); ?>
					</td>
				<?php else: ?>
					<td>
						<?php $ids = [$listeCompsTerm->id, $listeSousChapitre->id]; ?>
						<?php $ids = implode("|", $ids); ?>
						<?php echo $this->Html->link(__('Lier'),[
							'action' => 'add',
							$ids
						]); ?>
					</td>
				<?php endif; ?>
			<?php endforeach; ?>
			
        </tr>
        <?php endforeach; ?>
    </tbody>       
</table>

