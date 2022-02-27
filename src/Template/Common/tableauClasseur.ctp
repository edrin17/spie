<?php $this->assign('title', $titre); ?>

<?php
//@params listLVL1 selectedLVL1 -> tab1
//@params listLVL2 selectedLVL2 -> tab2
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
    <?php foreach($listLVL1 as $elementLVL1): ?>
        <li role="presentation" <?= isSelected($elementLVL1, $selectedLVL1) ?> >
            <?= $this->Html->link($elementLVL1->nom,[
                'controller'=> $nameController,
                'action'=> $nameAction,
                1,
                '?' => [
                    'LVL1' => $elementLVL1->id,
                    'spe' => $spe,
                    'options' => $options,
                    ]
            ]) ?>
        </li>
    <?php endforeach; ?>
</ul>

<ul class="nav nav-pills nav-justified">
    <?php foreach($listLVL2 as $elementLVL2): ?>
        <li role="presentation" <?= isSelected($elementLVL2, $selectedLVL2->id) ?> >
            <?= $this->Html->link($elementLVL2->nom,[
            'controller'=> $nameController,
            'action'=> $nameAction,
            1,
            '?' => [
                'LVL1' => $selectedLVL1,
                'LVL2' => $elementLVL2->id,
                'spe' => $spe,
                'options' => $options,
            ]
            ]) ?>
        </li>
    <?php endforeach; ?>
</ul>

<?= $this->fetch('content') ?>
