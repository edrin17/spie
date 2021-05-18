<div class="capacites view large-9 medium-8 columns content">
    <h3><?php echo 'C.',h($capacite->numero) ,': ' ,h($capacite->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?php echo __('Numéro') ?></th>
            <td><?php echo 'C.',h($capacite->numero) ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Nom') ?></th>
            <td><?php echo h($capacite->nom) ?></td>
        </tr>
    </table>
</div>

