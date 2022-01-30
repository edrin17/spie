<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Suivi&nbsp;<i class="fa fa-check-square-o" aria-hidden="true"></i>
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><?= $this->Html->link(__('Suivi des TP'), ['controller' => 'Suivis','action' => 'tp']); ?></li>
      <li><?= $this->Html->link(__('Positionnement'), ['controller' => 'Suivis','action' => 'suivi']); ?></li>
      <li><?= $this->Html->link(__('Cahier de texte'), ['controller' => 'GivenCourses','action' => 'index']); ?></li>
    </ul>
</li>
