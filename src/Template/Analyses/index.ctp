<?php
    $this->extend('/Common/tableauClasseur');
?>
<?php $this->assign('title', "Chronologie de l'acquisition des compétences"); ?>

<table class = 'table table-bordered table-hover'>
	<thead>
        <th></th>
        <?php foreach ($listTP as $value): ?>
            <th><?= $value ?></th>
        <?php endforeach; ?>
	</thead>
	<tbody>
        <?php foreach ($tableauComp as $idComp => $valueComp): ?>
            <tr>
                <td><?= $valueComp?></td>
                <?php foreach ($listTP as $idTP => $valueTP)
                {
                    $exist = isset($tableauMatch[$idComp][$idTP]);
                    if ($exist) {
                        echo '<td><h4 style="text-align:center"><i class="fa-solid fa-check" aria-hidden="true"></i></h4></td>';
                    } else {
                       echo '<td></i></td>';
                    }
                    
                } ?>
                    
            </tr>
        <?php endforeach; ?>
    </tbody>       
</table> 
