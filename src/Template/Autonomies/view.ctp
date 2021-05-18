<div class="autonomies view large-9 medium-8 columns content">
    <h3><?php echo 'N.',h($autonomie->numero) ,': ' ,h($autonomie->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?php echo __('Niveau') ?></th>
            <td><?php echo $autonomie->numero ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Nom') ?></th>
            <td><?php echo h($autonomie->nom) ?></td>
        </tr>
    </table>
 
</div>

