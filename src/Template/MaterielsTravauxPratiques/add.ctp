<div class="travauxPratiquesObjectifsPeda form large-9 medium-8 columns content">
    <?= $this->Form->create($tpMateriel) ?>
    <fieldset>
        <legend>
			<?= __('Associer le tp') ?>
			<font color = "green">
				<?= h($tp->nom) ?>
			</font>
			<?= ('avec un objectif pedagogique') ?>
		</legend>
            
        <?= $this->Form->input('materiel_id', [
            'label' => 'Liste des matériels',
            'options' => $listMateriels   
		]); ?>
			
		<?= $this->Form->input('travaux_pratique_id', [
            'value' => $id,
            'type' => 'hidden'    
		]); ?>
    </fieldset>
    <?= $this->Form->button(__('Associer', $id)); ?>
    <?= $this->Form->end(); ?>
</div>

