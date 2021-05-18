<div class="marques view large-9 medium-8 columns content">
    <h3><?= 'T.',h($marque->numero) ,': ' ,h($marque->nom) ?></h3>
    <table class="vertical-table">

            <th><?= __('Nom') ?></th>
            <td><?= h($marque->nom) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($marque->id) ?></tr>
        </tr>
    </table>
 
</div>

