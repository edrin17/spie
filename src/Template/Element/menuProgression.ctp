<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Progression&nbsp;<i class="fa fa-calendar" aria-hidden="true"></i>
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li>
            <?= $this->Html->link(__('Progression'), [
                'controller' => 'Progressions',
                'action' => 'index'
            ]); ?>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <?= $this->Html->link(__('T.P'), [
                'controller' => 'TravauxPratiques',
                'action' => 'index'
            ]); ?>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <?= $this->Html->link(__('T.P x Micro-Compétences'), [
                'controller' => 'TravauxPratiquesObjectifsPedas',
                'action' => 'view'
            ]); ?>
        </li>
        <li role="separator" class="divider"></li>
        <li>
            <?= $this->Html->link(__('Classes'), [
                'controller' => 'Classes',
                'action' => 'index'
            ]); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Élèves'), [
                'controller' => 'Eleves',
                'action' => 'index'
            ]); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Périodes'), [
                'controller' => 'Periodes',
                'action' => 'index'
            ]); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Rotations'), [
                'controller' => 'Rotations',
                'action' => 'index'
            ]); ?>
        </li>
        <li>
            <?= $this->Html->link(__('Thèmes'), [
                'controller' => 'Themes',
                'action' => 'index'
            ]); ?>
        </li>
    </ul>
</li>
