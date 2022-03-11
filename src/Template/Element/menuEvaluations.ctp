<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Évaluations&nbsp;<i class="fa fa-check" aria-hidden="true"></i>
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
    <li><?php echo $this->Html->link(__('Bilan'), ['controller' => 'Evaluations','action' => 'bilan']); ?></li>
    <li role="separator" class="divider"></li>
    <li><?php echo $this->Html->link(__('Valeurs Évals'), ['controller' => 'ValeursEvals','action' => 'index']); ?></li>
    <li><?php echo $this->Html->link(__('Types-Évals'), ['controller' => 'TypesEvals','action' => 'index']); ?></li>
    </ul>
</li>
