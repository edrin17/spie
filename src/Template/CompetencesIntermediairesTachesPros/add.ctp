<?php $select = [ 1 => 'À évaluer', 0 =>'En formation']?>
<div class="travauxPratiquesObjectifsPeda form large-9 medium-8 columns content">
    <?= $this->Form->create($travauxPratiquesObjectifsPeda); ?>
    <fieldset>
        <legend><?= __('Associer des objectifs pédagogiques avec ' .$nomTP->nom) ?></legend>
            <?= $this->Form->input('objectifs_peda_id', [
                'label' => 'Liste des objectifs pédagogiques',
                'options' => $listeObjectifs    
			]); ?>
			<?= $this->Form->input('travaux_pratique_id', [
                'value' => $id,
                'type' => 'hidden'    
			]); ?>
    </fieldset>
    <?= $this->Form->button(__('Envoyer', $id)); ?>
    <?= $this->Form->end(); ?>
</div>

