<div class="valeursEvals view large-9 medium-8 columns content">
    <h3><?= "Type d'évaluation: " .h($typesEval->nom) ?></h3>
    <table class="vertical-table">

            <th><?= __('Nom') ?></th>
            <td><?= h($typesEval->nom) ?></td>
        </tr>
        <tr>
            <th><?= __('Numéro') ?></th>
            <td><?= h($valeursEval->numero) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($typesEval->id) ?></tr>
        </tr>
    </table>
 
</div>

