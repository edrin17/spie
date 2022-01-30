<?php
//@params periodesList selectedPeriode -> tab1
//@params rotationsList selectedrotation -> tab2
//@params nameAction nameController -> for GET request
function isSelected ($itemToTest, $selectedItem) {
    if ($itemToTest->id === $selectedItem) {
        $selected = 'class="active"';
    }else{
        $selected = '';
    }
    return $selected;
}
?>

<ul class="nav nav-tabs nav-justified">
    <?php foreach($periodesList as $periode): ?>
        <li role="presentation" <?= isSelected($periode, $selectedPeriode) ?> >
            <?= $this->Html->link($periode->nom,[
                'controller'=> $nameController,
                'action'=> $nameAction,
                1,
                '?' => [
                    'periode' => $periode->id,
                    'options' => $options,
                    ]
            ]) ?>
        </li>
    <?php endforeach; ?>
</ul>

<ul class="nav nav-pills nav-justified">
    <?php foreach($rotationsList as $rotation): ?>
        <li role="presentation" <?= isSelected($rotation, $selectedRotation->id) ?> >
            <?= $this->Html->link($rotation->nom,[
            'controller'=> $nameController,
            'action'=> $nameAction,
            1,
            '?' => [
                'periode' => $selectedPeriode,
                'rotation' => $rotation->id,
                'options' => $options,
            ]
            ]) ?>
        </li>
    <?php endforeach; ?>
</ul>
