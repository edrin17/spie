<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Matériels&nbsp;<i class="fa-solid fa-motorcycle" aria-hidden="true"></i>
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li>
            <?= $this->Html->link(__('Matériels'), [
                'controller' => 'Materiels',
                'action' => 'index'
            ]); ?>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <?= $this->Html->link(__('Utilisation des supports'), [
                'controller' => 'MaterielsTravauxPratiques',
                'action' => 'view'
            ]); ?>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <?= $this->Html->link(__('Marques'), [
                'controller' => 'Marques',
                'action' => 'index'
            ]); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Propriétaires'), [
                'controller' => 'owners',
                'action' => 'index'
            ]); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Types-Machines'), [
            'controller' => 'TypesMachines',
            'action' => 'index'
            ]); ?>
        </li>
    </ul>
</li>
