<?php $this->assign('title', 'Edition du documents donné'); ?>  <!-- Customise le titre de la page -->
    <?= $this->Form->create($givenCourse); ?>
    <fieldset>
      <legend><?= __('Éditer un document') ?></legend>
        <?= $this->Form->input('name',[
			        'label' => 'Nom:',
		  ]); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer')); ?>
    <?= $this->Form->end(); ?>
</div>
