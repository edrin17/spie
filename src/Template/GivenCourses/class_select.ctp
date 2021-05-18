<?php $this->assign('title', 'Selection de le classe'); ?>  <!-- Customise le titre de la page -->
<div class="classes form large-9 medium-8 columns content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Selection de la classe') ?></legend>
        <?= $this->Form->input('classe_id',['label' => 'Classe']); ?>
        <?= $this->Form->hidden('givenCourse_id',['value' => $givenCourse_id]); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div>
