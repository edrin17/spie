<div class="classes view large-9 medium-8 columns content">
    <h3><?php echo 'Classe: ' .h($classe->nom); ?></h3>
    <table class="vertical-table">
            <th><?php echo __('Nom') ?></th>
            <td><?php echo h($classe->nom); ?></td>
        </tr>
        <tr>
            <th><?php echo __('Id') ?></th>
            <td><?php echo h($classe->id); ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Archived') ?></th>
            <td><?php echo h($classe->archived); ?></tr>
        </tr>
    </table>

</div>
