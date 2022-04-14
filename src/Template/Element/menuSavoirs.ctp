<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				Savoirs&nbsp;<i class="fa-solid fa-book" aria-hidden="true"></i>
			<span class="caret"></span></a>
			<ul class="dropdown-menu">
                <li>
                    <?= $this->Html->link(__('Chapitres'),[
                        'controller' => 'Chapitres',
                        'action' => 'index'
                    ]); ?>
                </li>
                <li>
                    <?= $this->Html->link(__('Sous-chapitres'),[
                        'controller' => 'SousChapitres',
                        'action' => 'index'
                    ]); ?>
                </li>
                <li>
                    <?= $this->Html->link(__('Sous-sous-chapitres'), [
                        'controller' => 'SousSousChapitres',
                        'action' => 'index'
                    ]); ?>
                </li>
                
                <li>
                    <?= $this->Html->link(__('Contenus Chapitres'), [
                        'controller' => 'ContenusChapitres',
                        'action' => 'index'
                    ]); ?>
                </li>
                
                <li role="separator" class="divider"></li>
                
                <li>
                    <?= $this->Html->link(__('Niveaux Taxonomiques'), [
                        'controller' => 'NiveauxTaxos',
                        'action' => 'index'
                    ]); ?>
                </li>	
			</ul>
		</li>
