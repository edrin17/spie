<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Évaluations&nbsp;<i class="fa fa-check" aria-hidden="true"></i>
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
    <li><?= $this->Html->link(__('Évaluations'), ['controller' => 'Evaluations','action' => 'index']); ?></li>
    <li role="separator" class="divider"></li>
    <li><?= $this->Html->link(__('Valeurs Évals'), ['controller' => 'ValeursEvals','action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Types-Évals'), ['controller' => 'TypesEvals','action' => 'index']); ?></li>
    </ul>
</li>
