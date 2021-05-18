<div class="owners form large-9 medium-8 columns content">
    <?= $this->Form->create($owner) ?>                       <!-- Crée un formulaire qui sera stocké d'un $capacité' -->
    <fieldset>
        <legend><?= __('Édition d\'une owner') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
    </fieldset>
    <?= $this->Form->button(__('Éditer')) ?> <!-- Affiche le bouton submit -->
    <?= $this->Form->end() ?> <!-- Ferme le formulaire -->
</div>
