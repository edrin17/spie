<div class="objectifsPeda view large-9 medium-8 columns content">
    <h3><?= "Objectif pédagogique: ". h($objectifsPeda->fullName) ?> </h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Capacité:') ?></th>
            <td><?= h(
				$objectifsPeda->competences_intermediaire->competences_terminale
				->capacite->fullName
            ) ?></tr>
        </tr>
        <tr>
            <th><?= __('Compétence terminale:') ?></th>
            <td><?= h(
				$objectifsPeda->competences_intermediaire->competences_terminale->fullName
            ) ?></tr>
        </tr>
        <tr>
            <th><?= __('Compétence intermédiaire:') ?></th>
            <td><?= h(
				$objectifsPeda->competences_intermediaire->fullName
            ) ?></tr>
        </tr>
        <tr>
            <th><?= __('Niveau de compétence:') ?></th>
            <td><?= h(
				$objectifsPeda->niveaux_competence->fullName
            ) ?></tr>
        </tr>
    </table>
</div>

