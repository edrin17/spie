<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Savoir-faire&nbsp;<i class="fa-solid fa-wrench" aria-hidden="true"></i>
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
    <li><?= $this->Html->link(__('Activités'), ['controller' => 'Activites','action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Tâches Professionnelles'), ['controller' => 'TachesPros','action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Autonomie'), ['controller' => 'Autonomies','action' => 'index']); ?></li>
    </ul>
</li>
