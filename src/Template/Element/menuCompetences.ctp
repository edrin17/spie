<li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        Compétences&nbsp;<i class="fa fa-cogs" aria-hidden="true"></i>
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
    <li><?= $this->Html->link(__('Capacités'), ['controller' => 'Capacites','action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Compétences Terminales'), ['controller' => 'CompetencesTerminales','action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Compétences Intermédiaires'), ['controller' => 'CompetencesIntermediaires','action' => 'index']); ?></li>
    <li><?= $this->Html->link(__('Objectifs Pédagogiques'), ['controller' => 'ObjectifsPedas','action' => 'index']); ?></li>
    <li role="separator" class="divider"></li>
    <li><?= $this->Html->link(__('Niveaux de compétence'), ['controller' => 'NiveauxCompetences','action' => 'index']); ?></li>
    </ul>
</li>
