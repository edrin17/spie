<div class="activites form large-9 medium-8 columns content">
    <?= $this->Form->create($activite) ?>                       <!-- Crée un formulaire qui sera stocké d'un $capacité' -->
    <fieldset>
        <legend><?= __('Édition d\'une activité') ?></legend>
        <?= $this->Form->input('nom',['label' => 'Nom']); ?>
        <?= $this->Form->input('numero',['label' => 'Numéro dans le référentiel']); ?>
    </fieldset>
    <?= $this->Form->button(__('Éditer')) ?> <!-- Affiche le bouton submit -->
    <?= $this->Form->end() ?> <!-- Ferme le formulaire -->
</div>
