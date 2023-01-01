<?php
$this->start('tableauClasseur');
echo $this->element('TableauxClasseurs/filtresPositionnement');
$this->end();
echo $this->fetch('tableauClasseur');
?>
<br>
<table class = 'table table-bordered table-hover'>
    <thead>
        <tr>
        <?php foreach($tableHeader as $key => $nom): ?>
            <th><?php echo $nom ?></th>
        <?php endforeach ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tableau as $ligne): ?>
        <tr>
            <?php for ($i = 0; $i <= $nbColonnes; $i++): ?>
                <td data-dismiss="modal" data-toggle="modal" data-target='#myModaltest' style='background-color:<?php echo $ligne[$i]['contenu']['bgcolor'] ?>' >
                    <?php echo $ligne[$i]['nom'] ?>
                </td>
            <?php endfor ?>
        </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div class="modal fade bs-example-modal-lg" id="myModaltest"  tabindex="-1" role="dialog" aria-labelledby="test">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?php echo 'test' ?> </h4>
        </div>
        <div class="modal-body">
            test
        </div>
        <div class="modal-footer"><!-- modal-footer -->
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button type="sumbit" class="btn btn-primary">Sauvegarder</button>
        </div><!-- /modal-footer -->
    </div>
  </div>
</div>
