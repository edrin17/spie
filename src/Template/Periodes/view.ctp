<div class="periodes view large-9 medium-8 columns content">
    <h3><?php echo h($periode->class->nom) .' - ' .'Période n°',h($periode->numero); ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?php echo __('Numéro') ?></th>
            <td><?php echo 'P.',h($periode->numero) ?></tr>
        </tr>
         <tr>
            <th><?php echo __('Classe') ?></th>
            <td><?php echo h($periode->class->nom) ?></tr>
    </table>
 
</div>

