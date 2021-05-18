<?php $this->assign('title', 'Association Matériels et T.P'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
          <table class="table">
    <h1> Matériels associés avec <font color = "#40CF40" ><?= h($tp->nom) ?> </font></h1>
    
    <?= $this->Html->link(__('Ajouter un matériel pédagogique pour ce TP'),
		['action' => 'add', $id]) ?>
        <thead>
            <tr>
                <th> Maériels associés </th>
                <th class="actions"><h3><?= __('Actions') ?></th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($listMateriels as $materiel): ?>
            <?php $tpMateriel = $materiel->_matchingData['MaterielsTravauxPratiques']; ?>
            <tr> 
                <td><?= h($materiel->fullName); ?></td>
				<td class="actions">
                <p>
                    <?= $this->Form->postLink(__('Supprimer'),
                        ['action' => 'delete', $tpMateriel->id],
                        ['confirm' => __('Etes vous sur de vouloirs supprimer {0}?',
							$tpMateriel->fullName)
						]
					) ?>
                </p>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>       
    </table>
</div>
