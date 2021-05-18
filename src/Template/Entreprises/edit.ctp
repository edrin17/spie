<?php 
//Execute la requête $capacité avec un foreach
foreach ($capacites as $capacite) 
{
    /*
     * Crée un tableau du type [idcompétence => C.2: Préparer]
     * sur mesure pour le helper input(select) de la vue.
     * Ici on veut avoir dans notre objet input de type select:
     * value=capacite_id et en affichage la chaîne concaténée*/
    $listeSelect[$capacite->id] = "C.". $capacite->numero.": " .$capacite->nom ;
}
?>

<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($competence) ?>                       <!-- Crée un formulaire qui sera stocké d'un $capacité' -->
    <fieldset>
        <legend><?= __("Édition d\'une Compétence Terminale") ?></legend>
            <?= $this->Form->input('nom',['label' => 'Nom']); ?>
            <!-- echo $this->Form->input('capacite_id',['label' => 'Capacité correspondante dans le référentiel','option' => 'select']); -->        
            <?= $this->Form->input('numero',[
                'label' => 'Numéro de la Compétence Terminale',
                'option' => 'number', 
                'min' => '1',
                'max' => '5'
            ]); ?>
            <?= $this->Form->input('capacite_id', [
                'label' => 'Capacité correspondante dans le référentiel',
                'options' => $listeSelect
            ]);?>
    </fieldset>
    <?= $this->Form->button(__('Éditer')) ?> <!-- Affiche le bouton submit -->
    <?= $this->Form->end() ?> <!-- Ferme le formulaire -->
</div>
