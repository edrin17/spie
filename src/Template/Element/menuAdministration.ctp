<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Administration&nbsp;<i class="fa-solid fa-unlock-alt" aria-hidden="true"></i>
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
    <li><?= $this->Html->link(__('Référentiels'),['controller' => 'Referentials','action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Progressions'),['controller' => 'Progressions','action' => 'index']); ?></li>
    <li role="separator" class="divider"></li>
    <li><?= $this->Html->link(__('Utilisateurs'), ['controller' => 'Users','action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Déconnexion'),['controller' => 'Users','action' => 'logout']); ?></li>
    </ul>
</li>
