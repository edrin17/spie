<?php $this->assign('title', 'Choix de la rotation'); ?>
<table class = "table table-striped table-bordered">
<tbody>
<?php foreach ($periodes as $periode) : ?>
	<tr>
		<td><?= "Période: " .$periode->numero ?></td>
		<?php foreach ($rotations as $rotation) : ?>
			<?php if ($rotation->periode->id == $periode->id): ?>
				<td class="actions">
					<p>	
                    <?= $this->Html->link('Évaluer P'.$periode->numero.".R.".$rotation->numero,[
                        'controller'=> $nameController,
                        'action'=> $nameAction,
                        1,
                        '?' => ['options' => $rotation->id]
                    ]) ?>
					</p>
			<?php endif; ?>
			
		<?php endforeach; ?>	
	</tr>
<?php endforeach; ?>
</tbody>		
</table>       

 

