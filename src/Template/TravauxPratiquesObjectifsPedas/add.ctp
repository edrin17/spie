<div class="travauxPratiquesObjectifsPeda form large-9 medium-8 columns content">
    <?php echo $this->Form->create($tpObjPeda) ?>
    <?php echo $this->Form->hidden('tp_id',['value' =>$tp_id]) ?>
    <?php echo $this->Form->hidden('selectedLVL2_id',['value' =>$selectedLVL2_id]) ?>
    <?php echo $this->Form->hidden('selectedLVL1_id',['value' =>$selectedLVL1_id]) ?>
    <fieldset>
        <legend>
			<?php echo __('Associer le tp') ?>
			<font color = "green">
				<?php echo h($tp->nom) ?>
			</font>
			<?php echo ('avec un objectif pedagogique') ?>
		</legend>

        <?php echo $this->Form->input('objectifs_peda_id', [
            'label' => 'Liste des objectifs pédagogiques',
            'options' => $listObjsPedas
		]); ?>

		<?php echo $this->Form->input('travaux_pratique_id', [
            'value' => $tp_id,
            'type' => 'hidden'
		]); ?>
    </fieldset>
    <?php echo $this->Form->button(__('Associer', $tp_id)); ?>
    <?php echo $this->Form->end(); ?>
</div>
