<div class="activites view large-9 medium-8 columns content">
    <h3><?= 'T.',h($activite->numero) ,': ' ,h($activite->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Numéro') ?></th>
            <td><?= 'T.',h($activite->numero) ?></tr>
        </tr>
        <tr>
            <th><?= __('Nom') ?></th>
            <td><?= h($activite->nom) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($activite->id) ?></tr>
        </tr>
    </table>

</div>
