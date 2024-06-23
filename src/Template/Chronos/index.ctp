<?php 
    $this->set('controller','Chronos');
    echo $this->element('TableauxClasseurs/filtreschronos');
?>

<table class = 'table table-bordered table-hover'>
	<thead>
        <th></th>
        <?php foreach ($tps as $tp): ?>
            <th><?= $tp ?></th>
        <?php endforeach; ?>
	</thead>
	<tbody>
        <?php foreach ($tableauComp as $idComp => $valueComp): ?>
            <tr>
                <td><?= $valueComp?></td>
                <?php foreach ($tps as $idTP => $valueTP)
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
