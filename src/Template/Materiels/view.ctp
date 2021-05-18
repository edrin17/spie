<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="page-header">
            <h2><span class="label label-info"><?= "Matériel: ". h($materiel->nom) ?></span></h2>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Marque:</h3>
            </div>
            <div class="panel-body">
              <?= h($materiel->marque->nom) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Type de machine:</h3>
            </div>
            <div class="panel-body">
              <?= h($materiel->types_machine->nom) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Propriétaire:</h3>
            </div>
            <div class="panel-body">
              <?= h($materiel->owner->nom) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Numéro:</h3>
            </div>
            <div class="panel-body">
              <?= h($materiel->numero) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
     <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Infos chassis:</h3>
            </div>
            <div class="panel-body">
              <?= h($materiel->infos_chassis) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Infos moteur:</h3>
            </div>
            <div class="panel-body">
                <?= h($materiel->infos_moteur) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
     <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Infos maintenance:</h3>
            </div>
            <div class="panel-body">
              <?= h($materiel->infos) ?>
            </div>
        </div>
    </div>
</div>
