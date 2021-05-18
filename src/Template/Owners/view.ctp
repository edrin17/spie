<div class="owners view large-9 medium-8 columns content">
    <h3><?= 'T.',h($owner->numero) ,': ' ,h($owner->nom) ?></h3>
    <table class="vertical-table">

            <th><?= __('Nom') ?></th>
            <td><?= h($owner->nom) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($owner->id) ?></tr>
        </tr>
    </table>

</div>
