<div class="sousChapitres view large-9 medium-8 columns content">
    <h3><?= 'S.' .$sousChapitre->chapitre->numero .'.' .$sousChapitre->numero .': ' .h($sousChapitre->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Chapitre:') ?></th>
            <td><?= h($sousChapitre->chapitre->NumeNom)?></tr>
        </tr>
    </table>
</div>

