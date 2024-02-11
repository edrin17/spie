<div class="travauxPratiquesObjectifsPeda form large-9 medium-8 columns content">
    <?php echo $this->Form->create($tpObjPeda) ?>
    <?php echo $this->Form->hidden('tp_id',['value' =>$tp_id]) ?>
    <?php echo $this->Form->hidden('referential_id',['value' =>$referential_id]) ?>
    <?php echo $this->Form->hidden('progression_id',['value' =>$progression_id]) ?>
    <?php echo $this->Form->hidden('periode_id',['value' =>$periode_id]) ?>
    <?php echo $this->Form->hidden('rotation_id',['value' =>$rotation_id]) ?>
    <?php echo $this->Form->hidden('classe_id',['value' =>$classe_id]) ?>
    <?php echo $this->Form->hidden('spe',['value' => $spe]) ?>
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
            'class' => 'selectpicker',
            'data-live-search' => "true",
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
