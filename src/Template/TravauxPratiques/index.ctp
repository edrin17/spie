<?php
    $this->extend('/Common/tableauClasseur'); // Affiche les onglets

    if ($spe) {
        $html['spe'] = 0;
        $html['label'] = 'Voir les TP normaux';
        $html['color'] = 'btn-success';
    }else {
        $html['spe'] = 1;
        $html['label'] = 'Voir les TP spécifiques';
        $html['color'] = 'btn-warning';
    }
?>
<?php $this->assign('title', 'Travaux Pratiques'); ?>  <!-- Customise le titre de la page -->
<br>
<div class="row">
    <div class="col-md-3">
        <?php echo $this->Html->link('Ajouter un TP',
            ['action' => 'add'],['class' => "btn btn-default",'role' => 'button' ]); ?>
    </div>
    <div class="col-md-8">
        <?php echo $this->Html->link($html['label'],
            ['action' => 'index',1,
                '?' => [
                    'LVL1' => $selectedLVL1,
                    'LVL2' => $selectedLVL2->id,
                    'spe' => $html['spe'],
                    'options' => $options,
                ]
            ],['class' => "btn ".$html['color'],'role' => 'button' ]); ?>
    </div>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th> Nom du TP </th>
            <th><h3>Actions</h3></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listTPs as $tp): ?> <!--Affiche le contenu de 'activitess'  -->
        <tr>
            <td><?php echo $this->Html->link($tp->nom,
                ['action' => 'edit', $tp->id]); ?></td>
			<td class="actions">
                <div class="btn-group" role="group" >
                    <div class="btn-group" role="group">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li>
                                <?php echo $this->Html->link('Objectifs pédagogiques', [
            						'controller' => 'TravauxPratiquesObjectifsPedas',
            						'action' => 'index',
        						    $tp->id,'?' => ['selectedLVL2_id' => $selectedLVL2->id, 'selectedLVL1_id' => $selectedLVL1]
                                ]).PHP_EOL; ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link(__('Matériels pour ce TP'), [
            						'controller' => 'MaterielsTravauxPratiques',
            						'action' => 'index',
            					$tp->id]).PHP_EOL; ?>
                            </li>
                        </ul>
                    </div>
                    <?php echo $this->Form->postButton(
                        '<i class="fa fa-trash" aria-hidden="true"></i>',
                        ['controller' => 'TravauxPratiques', 'action' => 'delete', $tp->id],
                        ['confirm' => 'Etes-vous sûr de voulour supprimer le TP: '.$tp->nom.'?' ,'escape'=> false]
                    );?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
