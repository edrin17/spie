<?php 
    //Execute la requête $capacites avec un foreach
    foreach ($capacites as $capacite) 
{
	
} 
?>
<div class="competences view large-9 medium-8 columns content">
    <h3><?='C.', h($capacite->numero),'.', h($competence->numero),': ', h($competence->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Capacité') ?></th>
            <td><?= 'C.', h($capacite->numero),': ', h($capacite->nom) ?></tr>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($competence->id) ?></tr>
        </tr>
        <tr>
            <th><?= __('Clé étrangère capacite_id') ?></th>
            <td><?= h($competence->capacite_id) ?></tr>
        </tr>
    </table>

</div>

