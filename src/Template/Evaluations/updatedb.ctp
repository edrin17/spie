<?php $this->assign('title', 'Liste des évals'); ?>
<table class = "table table-striped table-bordered">
<tr>
    <th>Id</th>
    <th>TP</th>
    <th>Objectifs peda</th>
</tr>
<tbody>
<?php foreach ($evalsList as $eval) : ?>
	<tr>
		<td><?= $eval->id ?></td>
        <td><?= h($eval->travaux_pratiques_objectifs_peda->travaux_pratique->nom) ?></td>
        <td><?= h($eval->travaux_pratiques_objectifs_peda->objectifs_peda->nom) ?></td>
	</tr>
<?php endforeach; ?>
</tbody>		
</table>       

 

