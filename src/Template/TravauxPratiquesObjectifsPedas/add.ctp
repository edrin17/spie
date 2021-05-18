<div class="travauxPratiquesObjectifsPeda form large-9 medium-8 columns content">
    <?= $this->Form->create($tpObjPeda) ?>
    <fieldset>
        <legend>
			<?= __('Associer le tp') ?>
			<font color = "green">
				<?= h($tp->nom) ?>
			</font>
			<?= ('avec un objectif pedagogique') ?>
		</legend>
            
        <?= $this->Form->input('objectifs_peda_id', [
            'label' => 'Liste des objectifs pédagogiques',
            'options' => $listObjsPedas    
		]); ?>
			
		<?= $this->Form->input('travaux_pratique_id', [
            'value' => $id,
            'type' => 'hidden'    
		]); ?>
    </fieldset>
    <?= $this->Form->button(__('Associer', $id)); ?>
    <?= $this->Form->end(); ?>
</div>

