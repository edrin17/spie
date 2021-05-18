<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($sousChapitre) ?>                       <!-- Crée un formulaire qui sera stocké d'un $capacité' -->
    <fieldset>
        <legend><?= __("Édition d'un sous chapitre") ?></legend>
            <?= $this->Form->input('nom',['label' => 'Nom']); ?>
            <!-- echo $this->Form->input('Chapitre_id',['label' => 'Capacité correspondante dans le référentiel','option' => 'select']); -->        
            <?= $this->Form->input('numero',[
                'label' => 'Numéro du sous-chapitre',
                'option' => 'number', 
                'min' => '1',
                'max' => '10'
            ]); ?>
            <?= $this->Form->input('chapitre_id', [
                'label' => 'Chapitre correspondante dans le référentiel',
                'options' => $listeChapitres
            ]);?>
    </fieldset>
    <?= $this->Form->button(__('Valider')) ?> <!-- Affiche le bouton submit -->
    <?= $this->Form->end() ?> <!-- Ferme le formulaire -->
</div>
