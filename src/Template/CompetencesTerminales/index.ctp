<?php $this->assign('title', 'Liste des compétences terminales'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
        <table class="table">
    <h1>Compétences terminales</h1>
    <div class="col-lg-1 col-lg">
        <br>
        <?php echo $this->Html->link('Ajouter une compétence', ['action' => 'add'],
            ['class' => "btn btn-info",'type' => 'button' ]
        ); ?>
    </div>
		<thead>
            <tr>
                <th> Capacités </th>
                <th> Compétences Terminale </th>
                <th class="actions">
					<h3><?= __('Actions') ?>
				</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listeCompsTerms as $listeCompsTerm): ?> <!--Affiche le contenu de 'capacitess'  -->
            <tr> 
                <td><?= h($listeCompsTerm->capacite->fullName) ?></td>
                <td><?= h($listeCompsTerm->fullName) ?></td> <!-- Ici on ajoute C. pour avoir une compétence de la forme C.3.2.1 -->
				<td class="actions">
                <!-- Affiche des urls/boutons et de leurs actions -->
                <p>
                    <?= $this->Html->link(
						__('Voir'),['action' => 'view', $listeCompsTerm->id]
					)?>
                    <?= $this->Html->link(
						__('Editer'),['action' => 'edit', $listeCompsTerm->id]
					)?>
                    <?= $this->Form->postLink(
						__('Supprimer'),['action' => 'delete', $listeCompsTerm->id],
                        ['confirm' => __(
							'Etes vous sur de vouloirs supprimer # {0}?', $listeCompsTerm->id
						)]
					)?>
                </p>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>       
    </table>
    
</div>
