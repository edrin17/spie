<div class="users form large-9 medium-8 columns content">
    <?php echo $this->Form->create($niveauxTaxo) ?>
    <fieldset>
        <legend><?php echo __('Ajouter un niveauxTaxo') ?></legend>
        <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>
        <?php echo $this->Form->input('numero',['label' => 'Numéro']); ?>
    </fieldset>
    <?php echo $this->Form->button(__('Envoyer')) ?>
    <?php echo $this->Form->end() ?>
</div>
