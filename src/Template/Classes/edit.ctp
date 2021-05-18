<div class="classes form large-9 medium-8 columns content">
    <?= $this->Form->create($classe) ?>
    <fieldset>
        <legend><?= __("Edition d'une classe") ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
        Archivage:
        <?= $this->Form->radio('archived', ['Non', 'Oui']); ?>
        <?= $this->Form->input('referential_id', [
          'label' => 'Reférentiel:'
        ]); ?>

    </fieldset>
    <?= $this->Form->button(__('Envoyer')) ?>
    <?= $this->Form->end() ?>
</div
