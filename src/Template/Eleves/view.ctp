<div class="materiel view large-9 medium-8 columns content">
    <h3><?php echo 'Élève: ' .h($eleve->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?php echo __('Nom:') ?></th>
            <td><?php echo h($eleve->nom); ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Prénom:') ?></th>
            <td><?php echo h($eleve->prenom); ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Classe') ?></th>
            <td><?php echo h($classe->nom) ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Id') ?></th>
            <td><?php echo h($eleve->id) ?></tr>
        </tr>
		<tr>
            <th><?php echo __('clé étrangère classe_id') ?></th>
            <td><?php echo h($eleve->classe_id) ?></tr>
        </tr>
    </table>
</div>


