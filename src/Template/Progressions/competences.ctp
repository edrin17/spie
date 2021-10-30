<?php $this->assign('title', "Compétences en fonction du temps"); ?>
<?php //var_dump($progression); ?>

<table class = 'table table-bordered table-hover'>
    <thead>
        <tr>
            <td></td>
            <?php for ($i=1; $i< count($listTPs); $i++): ?>
                <td> <?php echo $progression[0][$i] ?></td>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php for ($row=1; $row < count($listComps); $row++): ?>
            <tr>
                <?php for ($col=0; $col < count($listTPs); $col++): ?>
                <td> <?php echo $progression[$row][$col] ?></td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>
