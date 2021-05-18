<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        SPIE: Suivi et Progression Individuelle des Elèves: <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    
    <?= $this->Html->script('jquery-3.0.0.min.js'); ?>
    <?php //= $this->Html->script('jquery.chained.js'); ?>
    
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 colmuns">
            <li class="name">
                <h1><a href=""><?= $this->fetch('title') ?></a></h1>
            </li>
        </ul>
        <section class="top-bar-section">
            <ul class="right">
				<li><?= $this->Html->link(__('Suivis'), ['controller' => 'Suivis','action' => 'index']); ?></li>
				<li><?= $this->Html->link(__('Mode Admin'), ['controller' => 'TravauxPratiques','action' => 'index']); ?></li>				
                <li><?= $this->Html->link(__('Déconnexion'), ['controller' => 'Users','action' => 'logout']); ?></li>
            </ul>
        </section>
    </nav>
    <?= $this->Flash->render() ?>
    <section class="container clearfix">
        <?= $this->fetch('content') ?>
    </section>
    <footer>
    </footer>
</body>
</html>
