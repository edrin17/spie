<div class="competencesIntermediaires view large-9 medium-8 columns content">
    <h3><?= "C."
			.h($listeCompetencesTerminales[$competencesIntermediaire->id]['capaciteNumero'])
			."."
			.h($listeCompetencesTerminales[$competencesIntermediaire->id]['competenceTerminaleNumero'])
			."."
			.h($competencesIntermediaire->numero) 
			.": "
			.h($competencesIntermediaire->nom); ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Capacité') ?></th>
            <td><?= "C."
				.h($listeCompetencesTerminales[$competencesIntermediaire->id]['capaciteNumero'])
				.": "
				.h($listeCompetencesTerminales[$competencesIntermediaire->id]['capaciteNom']);
				 ?></tr>
        </tr>
        <tr>
            <th><?= __('Compétence terminale') ?></th>
            <td><?= "C."
				.h($listeCompetencesTerminales[$competencesIntermediaire->id]['capaciteNumero'])
				."."
				.h($listeCompetencesTerminales[$competencesIntermediaire->id]['competenceTerminaleNumero'])
				.": "
				.h($listeCompetencesTerminales[$competencesIntermediaire->id]['competenceTerminaleNom']);
				 ?></tr>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= h($competencesIntermediaire->id) ?></tr>
        </tr>
        <tr>
            <th><?= __('Clé étrangère competencesIntermediaires_terminale_id') ?></th>
            <td><?= h($competencesIntermediaire->competences_terminale_id) ?></tr>
        </tr>
    </table>

</div>

