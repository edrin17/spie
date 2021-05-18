<?php $this->assign('title', 'Erreur structurelle'); ?>  <!-- Customise le titre de la page -->
<div class="row">
    <div class="col-lg-12">
    <table class="table table-bordered table-stripped">
        <thead>
            <tr>
                <th>Compétence Intermédiaire</th>
                <th>Nom de l'objectif pédagogique'</th>
                <th>Nom du TP</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tablErrors as $error): ?>
            <tr>
                <?php foreach($error as $key => $value): ?>
                    <td><?= $value ?></td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

