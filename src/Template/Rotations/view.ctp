<div class="periodes view large-9 medium-8 columns content">
    <h3><?= "Classe" ." - Période n°" .h($rotation->periode->numero) ." - Rotation n°" .h($rotation->numero) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Thèmes') ?></th>
            <td><?= h($rotation->theme->nom) ?></tr>
        </tr>
        <tr>
            <th><?= __('Période') ?></th>
            <td><?= 'P.', h($rotation->periode->numero) ?></tr>
        </tr>
        <tr>
            <th><?= __('Rotation') ?></th>
            <td><?= 'R.', h($rotation->numero) ?></tr>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($rotation->id) ?></tr>
        </tr>
        <tr>
            <th><?= __('Clé étrangère periode_id') ?></th>
            <td><?= h($rotation->periode_id) ?></tr>
        </tr>
    </table>
</div>

