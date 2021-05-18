<div class="eleves form large-9 medium-8 columns content">
    <?= $this->Form->create($givenCourse); ?>
    <fieldset>
      <legend><?= __('Ajouter un document') ?></legend>
        <?= $this->Form->input('name',[
			      'label' => 'Nom:',
        ]); ?>
    </fieldset>
    <?= $this->Form->button(__('Enregistrer')); ?>
    <?= $this->Form->end(); ?>
</div>
