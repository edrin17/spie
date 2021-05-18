<div class="chapitres view large-9 medium-8 columns content">
    <h3><?= 'S.',h($chapitre->numero) ,': ' ,h($chapitre->nom) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Numéro') ?></th>
            <td><?= 'S.',h($chapitre->numero) ?></tr>
        </tr>
        <tr>
            <th><?= __('Nom') ?></th>
            <td><?= h($chapitre->nom) ?></td>
        </tr>
    </table>
 
</div>

