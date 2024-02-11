<?php
$this->set('controller','TravauxPratiques');
echo $this->element('TableauxClasseurs/filtres');


if ($spe) {
    $html['spe'] = 0;
    $html['label'] = 'Voir les TP normaux';
    $html['color'] = 'btn-success';
} else {
    $html['spe'] = 1;
    $html['label'] = 'Voir les TP spécifiques';
    $html['color'] = 'btn-warning';
}
?>
<div class="row">
    <div class="col-md-3">
        <?php echo $this->Html->link(
            'Ajouter un TP',
            ['action' => 'add', '?' => [
                'referential_id' => $referential_id,
                'rotation_id' => $rotation_id,
                'periode_id' => $periode_id,
                'progression_id' => $progression_id,
                'classe_id'=> $classe_id,
                'spe' => $spe]],
            ['class' => "btn btn-info", 'role' => 'button']
        ); ?>
    </div>
</div>
<table class="table table-hover">
    <thead>
        <tr>
            <th>Nom du TP</th>
            <th>
                <h3>Actions</h3>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tps as $tp) : ?>
            <!--Affiche le contenu de 'activitess'  -->
            <tr>
                <td><?php echo $this->Html->link(
                        $tp->nom,
                        ['action' => 'edit', $tp->id, '?' => [
                            'referential_id' => $referential_id,
                            'rotation_id' => $rotation_id,
                            'periode_id' => $periode_id,
                            'progression_id' => $progression_id,
                            'classe_id'=> $classe_id,
                            'spe' => $spe]]
                    ); ?></td>
                <td class="actions">
                    <div class="btn-group" role="group">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-link" aria-hidden="true"></i>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li>
                                    <?php echo $this->Html->link('Objectifs pédagogiques', [
                                        'controller' => 'TravauxPratiquesObjectifsPedas',
                                        'action' => 'index',
                                        $tp->id, '?' => [
                                            'referential_id' => $referential_id,
                                            'rotation_id' => $rotation_id,
                                            'periode_id' => $periode_id,
                                            'progression_id' => $progression_id,
                                            'classe_id'=> $classe_id,
                                            'spe' => $spe
                                            ]
                                    ]) . PHP_EOL; ?>
                                </li>
                                <li>
                                    <?php echo $this->Html->link(__('Matériels pour ce TP'), [
                                        'controller' => 'MaterielsTravauxPratiques',
                                        'action' => 'index',
                                        $tp->id, '?' => [
                                            'referential_id' => $referential_id,
                                            'rotation_id' => $rotation_id,
                                            'periode_id' => $periode_id,
                                            'progression_id' => $progression_id,
                                            'classe_id'=> $classe_id,
                                            'spe' => $spe
                                        ]
                                    ]) . PHP_EOL; ?>
                                </li>
                            </ul>
                        </div>
                    <?php echo $this->Form->postButton(
                        '<i class="fa-solid fa-trash" aria-hidden="true"></i>',
                        ['controller' => 'TravauxPratiques', 'action' => 'delete', $tp->id, '?' => [
                            'referential_id' => $referential_id,
                            'rotation_id' => $rotation_id,
                            'periode_id' => $periode_id,
                            'progression_id' => $progression_id,
                            'classe_id'=> $classe_id,
                            'spe' => $spe]],
                        ['confirm' => 'Etes-vous sûr de voulour supprimer le TP: ' . $tp->nom . '?', 'escape' => false]
                    ); ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>