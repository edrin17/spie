<div class="valeursEvals view large-9 medium-8 columns content">
    <h3><?= 'Valeur d\'évaluation: ' ,h($valeursEval->nom) ?></h3>
    <table class="vertical-table">
		<tr>
            <th><?= __('Nom') ?></th>
            <td><?= h($valeursEval->nom) ?></td>
        </tr>
        <tr>
            <th><?= __('Numéro') ?></th>
            <td><?= h($valeursEval->numero) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($valeursEval->id) ?></tr>
        </tr>
    </table>
 
</div>

