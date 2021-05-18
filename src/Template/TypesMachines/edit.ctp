<div class="typesMachines form large-9 medium-8 columns content">
    <?= $this->Form->create($typesMachine) ?>                       <!-- Crée un formulaire qui sera stocké d'un $capacité' -->
    <fieldset>
        <legend><?= __('Édition d\'un type de machine') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
    </fieldset>
    <?= $this->Form->button(__('Éditer')) ?> <!-- Affiche le bouton submit -->
    <?= $this->Form->end() ?> <!-- Ferme le formulaire -->
</div>
