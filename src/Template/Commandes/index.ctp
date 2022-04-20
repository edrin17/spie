
<?php $this->assign('title', 'Commandes'); ?>
<?php echo $this->Form->create($commande).PHP_EOL; ?>
    <div class="row">
        <div class="col-lg-1">
            <div class="page-header">
                <h2><span class="label label-info">Commandes</span></h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <div class="form-group">
                <?php echo $this->Form->input('text',[
                    'label' => 'Commandes:',
                    'type' => 'textarea',
                    'class' => 'form-control',
                    'rows' => '20',
                ]).PHP_EOL;?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3">
            <?php echo $this->Html->link(
                'Annuler',
                ['controller' => 'Commandes','action' => 'index'],
                ['class' => "btn btn-default",'role' => 'button',
                    'confirm' => 'Etes-vous sûr de vouloir annuler ?']
            ).PHP_EOL;?>
        </div>
        <div class="col-lg-3 col-lg-offset-6">
          <?php echo $this->Form->button(__('Mettre à jour'),[
            'class' => 'btn btn-success',
            'confirm' => 'Etes-vous sûr de vouloir mettre à jour les commandes ?'
          ]).PHP_EOL;?>
        </div>
    </div>
<?php echo $this->Form->end(); ?>
