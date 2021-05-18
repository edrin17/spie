<div class="contenuChapitre view large-9 medium-8 columns content">
    <h3><?= "Contenu de chapitre" ?> </h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Sous-sous-chapitre') ?></th>
            <td><?= 'S.', h($sousSousChapitre->numero),': ', h($sousSousChapitre->nom) ?></tr>
        </tr>
        <tr>
            <th><?= __('Niveau Taxonomique') ?></th>
            <td><?= 'N.', h($niveauxTaxo->numero),': ', h($niveauxTaxo->nom) ?></tr>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($contenusChapitre->id) ?></tr>
        </tr>
    </table>
</div>

