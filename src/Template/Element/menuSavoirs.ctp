<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				Savoirs&nbsp;<i class="fa-solid fa-book" aria-hidden="true"></i>
			<span class="caret"></span></a>
			<ul class="dropdown-menu">
                <li>
                    <?php echo $this->Html->link(__('Savoirs'),[
                        'controller' => 'Savoirs',
                        'action' => 'index'
                    ]); ?>
                </li>
                <li>
                    <?php echo $this->Html->link(__('Chapitres'),[
                        'controller' => 'Chapitres',
                        'action' => 'index'
                    ]); ?>
                </li> 
                <li>
                    <?php echo $this->Html->link(__('Sous Chapitres'),[
                        'controller' => 'SousChapitres',
                        'action' => 'index'
                    ]); ?>
                </li>               
                <li role="separator" class="divider"></li>
                
                <li>
                    <?php echo $this->Html->link(__('Niveaux Taxonomiques'), [
                        'controller' => 'NiveauxTaxos',
                        'action' => 'index'
                    ]); ?>
                </li>	
			</ul>
		</li>
