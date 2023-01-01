<?php $this->assign('title', 'Choix de la rotation');
$this->start('tableauClasseur');
echo $this->element('TableauxClasseurs/filtresBilan');
$this->end();
echo $this->fetch('tableauClasseur');
?>
<br>
<table class="table table-striped table-bordered">
    <thead>
        <td></td>
        <td>Trimestre 1</td>
        <td>Trimestre 2</td>
        <td>Trimestre 3</td>
    </thead>
    <tbody>
        <tr>
            <td>Nombre de TP évalués</td>
            <?php foreach ($nb_tps as $key => $nb) {
                echo '<td>' . $nb_tps[$key] . '</td>';
            } ?>
        </tr>
        <tr>
            <td>Nombre d'objectifs évalués</td>
            <?php foreach ($nb_evals as $key => $nb) {
                echo '<td>' . $nb_evals[$key] . '</td>';
            } ?>
        </tr>
        <tr>
            <td>Nombre d'objectifs atteints</td>
            <?php foreach ($note as $note_trim) {
                echo '<td>' . $note_trim['atteint'] . '</td>';
            } ?>
        </tr>
        <tr>
            <td>dont sommatifs</td>
            <?php foreach ($note as $note_trim) {
                echo '<td>' . $note_trim['sommatif'] . '</td>';
            } ?>
        </tr>
        <tr>
            <td>Note sur 20</td>
            <?php foreach ($note as $note_trim) {
                echo "<td style='background-color:" . $note_trim['bg_color'] . "'>" . $note_trim['sur20'] . '</td>';
            } ?>
        </tr>
    </tbody>
</table>