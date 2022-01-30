<?php
$this->start('tableauClasseur');
echo $this->element('TableauxClasseurs/suivi_tp');
$this->end();
echo $this->fetch('tableauClasseur');
foreach ($listEleves as $eleve) {
    echo h($eleve->nom) .'<br>';
}
?>
