<div class="users form large-9 medium-8 columns content">
    <?php echo $this->Form->create($capacite) ?>                       <!-- Crée un formulaire qui sera stocké d'un $capacité' -->
    <fieldset>
        <legend><?php echo __('Édition de la capacité') ?></legend>
        <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>
        <?php echo $this->Form->input('numero',['label' => 'Numéro dans le référentiel']); ?>
    </fieldset>
    <?php echo $this->Form->button(__('Éditer')) ?> <!-- Affiche le bouton submit -->
    <?php echo $this->Form->end() ?> <!-- Ferme le formulaire -->
</div>
