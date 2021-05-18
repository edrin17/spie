<div class="sousSousChapitres view large-9 medium-8 columns content">
    <h3><?php echo "S." .$sousSousChapitre->sous_chapitre->chapitre->numero
			."." .$sousSousChapitre->sous_chapitre->numero
			."." .$sousSousChapitre->numero 
			." - ".h($sousSousChapitre->nom); ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?php echo __('Chapitre') ?></th>
            <td><?php echo h($sousSousChapitre->sous_chapitre->chapitre->NumeNom); ?></tr>
        </tr>
        <tr>
            <th><?php echo __('Sous-chapitre') ?></th>
            <td><?php echo "S." .$sousSousChapitre->sous_chapitre->chapitre->numero
			."." .$sousSousChapitre->sous_chapitre->numero
			." - " .h($sousSousChapitre->sous_chapitre->nom); ?></tr>
        </tr>
    </table>

</div>

