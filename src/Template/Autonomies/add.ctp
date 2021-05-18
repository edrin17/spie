<div class="users form large-9 medium-8 columns content">
    <?php echo $this->Form->create($autonomie) ?>
    <fieldset>
        <legend><?php echo __('Ajouter un niveau d\'autonomie') ?></legend>
        <?php echo $this->Form->input('nom',['label' => 'Nom']); ?>
        <?php echo $this->Form->input('numero',['label' => 'Niveau']); ?>
    </fieldset>
    <?php echo $this->Form->button(__('Valider')) ?>
    <?php echo $this->Form->end() ?>
</div>
