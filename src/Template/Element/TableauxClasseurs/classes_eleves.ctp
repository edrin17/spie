<?php
//@params classesList selectedClasse -> tab1
//@params elevesList selectedEleve -> tab2
//@params nameAction nameController -> for GET request
function isSelected2 ($itemToTest, $selectedItem) {
    if ($itemToTest->id === $selectedItem) {
        $selected = 'class="active"';
    }else{
        $selected = '';
    }
    return $selected;
}
?>

<ul class="nav nav-tabs nav-justified">
    <?php foreach($classesList as $classe): ?>
        <li role="presentation" <?= isSelected2($classe, $selectedClasse) ?> >
            <?= $this->Html->link($classe->nom,[
                'controller'=> $nameController,
                'action'=> $nameAction,
                1,
                '?' => [
                    'classe' => $classe->id,
                    'options' => $options,
                    ]
            ]) ?>
        </li>
    <?php endforeach; ?>
</ul>

<ul class="nav nav-pills nav-justified">
    <?php foreach($elevesList as $eleve): ?>
        <li role="presentation" <?= isSelected2($eleve, $selectedEleve->id) ?> >
            <?= $this->Html->link($eleve->nom,[
            'controller'=> $nameController,
            'action'=> $nameAction,
            1,
            '?' => [
                'classe' => $selectedClasse,
                'eleve' => $eleve->id,
                'options' => $options,
            ]
            ]) ?>
        </li>
    <?php endforeach; ?>
</ul>
