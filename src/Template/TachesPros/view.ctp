<div class="tachePros view large-9 medium-8 columns content">
    <h3><?php echo 'T.' .$tachesPro->activite->numero .'.' .h($tachesPro->numero) .': ' .h($tachesPro->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?php echo __('Activité') ?></th>
            <td><?php echo h($tachesPro->activite->NumeNom) ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Niveau d\'autonomie') ?></th>
            <td><?php echo h($tachesPro->autonomy->NumeNom) ?></tr>
        </tr>
    </table>
</div>

