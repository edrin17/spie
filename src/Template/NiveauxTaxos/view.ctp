<div class="niveauxTaxos view large-9 medium-8 columns content">
    <h3><?php echo 'S.',h($niveauxTaxo->numero) ,': ' ,h($niveauxTaxo->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?php echo __('Numéro') ?></th>
            <td><?php echo 'N.',h($niveauxTaxo->numero) ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Nom') ?></th>
            <td><?php echo h($niveauxTaxo->nom) ?></td>
        </tr>
    </table>
 
</div>

