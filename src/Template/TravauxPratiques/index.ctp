<?php
    $this->extend('/Common/tableauClasseur'); // Affiche les onglets
?>
<?php $this->assign('title', 'Travaux Pratiques'); ?>  <!-- Customise le titre de la page -->
<br>
<a class="btn btn-default" role="button" href="../../travaux-pratiques/add/">Ajouter un TP</a>
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
            <td><?= $this->Html->link($tp->nom,
                ['action' => 'edit', $tp->id]); ?></td>
			<td class="actions">
                <div class="btn-group" role="group" aria-label="...">
                    <div class="btn-group" role="group">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-link" aria-hidden="true"></i>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li>
                                <?= $this->Html->link(__('Associer avec un objectif pédagogique'), [
            						'controller' => 'TravauxPratiquesObjectifsPedas',
            						'action' => 'add',
        						    $tp->id
                                ]).PHP_EOL; ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Associer avec un matériel'), [
            						'controller' => 'MaterielsTravauxPratiques',
            						'action' => 'add',
            					    $tp->id
                                ]).PHP_EOL; ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Voir les associations avec un matériel'), [
            						'controller' => 'MaterielsTravauxPratiques',
            						'action' => 'index',
            					$tp->id]).PHP_EOL; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
