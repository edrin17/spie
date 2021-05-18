<?php $this->assign('title', "Taux d'utilisation des supports"); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="page-header">
            <h2><span class="label label-info">Taux d'utilisation des supports</span></h2>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table id = "tableau" class="table display">
            <thead>
                <tr>
                    <th>Matériel</th>
                    <th>Nb d'utilisations</th>
                    <th>Taux en %</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listMateriels as $materiel): ?>
                    <tr>
                        <td><?= $materiel->fullName ?></td>
                        <td>
                            <span class="label label-default label-as-badge">
                                <?= $materiel->nbTPs ?>
                            </span>
                        </td>
                        <td>
                            <span class="label label-<?= $materiel->color ?> label-as-badge">
                                <?= round(($materiel->nbTPs*100/$nbTotal),2) ."%"; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>       
        </table>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#tableau').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
        },
        paging: false
    });
} );
</script>
