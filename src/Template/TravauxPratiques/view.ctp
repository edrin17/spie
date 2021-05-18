<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="page-header">
            <h2><span class="label label-info"><?= "TP: ". h($tp->nom) ?></span></h2>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-2">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Classe:</h3>
            </div>
            <div class="panel-body">
              <?= h($tp->rotation->periode->class->nom) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Rotation:</h3>
            </div>
            <div class="panel-body">
              <?= h($tp->rotation->fullName) ?>
            </div>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Thème:</h3>
            </div>
            <div class="panel-body">
              <?= h($tp->rotation->theme->nom) ?>
            </div>
        </div>
    </div>
</div>
<div class="row">    
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">Remarques</h3>
            </div>
            <div class="panel-body">
                <?= h($tp->comments) ?>
            </div>
        </div>
    </div>
</div>


