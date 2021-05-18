<div class="niveauxCompetences view large-9 medium-8 columns content">
    <h3><?php echo 'Niveau de compétence: ',h($niveauxCompetence->fullName) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?php echo __('Numéro de niveau: ') ?></th>
            <td><?php echo h($niveauxCompetence->numero) ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Nom: ') ?></th>
            <td><?php echo h($niveauxCompetence->nom) ?></td>
        </tr>

    </table>
 
</div>

