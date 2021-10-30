<?php echo $this->Html->docType('html5'); ?>
<head>
	<title>SPIE: Suivi et Progression Individuelle des Elèves:<?php echo $this->fetch('title') ?></title>
	<?php echo $this->Html->charset() ?>
	<?php echo $this->Html->meta('icon') ?>
	<?php echo $this->Html->meta(
		'viewport',
		'width=device-width, initial-scale=1'
	); ?>
	<?php echo $this->Html->css([
    	'jquery.dataTables.min.css',
        'bootstrap.min.css',
        'all.css', //fontawesome
        'bootstrap-select.css',
        'custom',
    //'../easyui/themes/default/easyui.css',
    //'../easyui/themes/icon.css'
  ]) ?>
	<?php echo $this->Html->script([
		'jquery.min.js',
		'bootstrap.min.js',
        'bootstrap-select.min.js',
		'jquery.dataTables.min.js',
    //'easyui/jquery.easyui.min.js',
	]) ?>
</head>
<body>
	<nav class ="navbar navbar-inverse">
	<div class = "container-fluid">
		<div class="navbar-header">
	      <a class="navbar-brand">SPIE</a>
	  </div>
		<ul class="nav navbar-nav">
			<?php echo $this->element('menuSavoirsFaire') ?>
	    <?php echo $this->element('menuCompetences') ?>
	    <?php echo $this->element('menuSavoirs') ?>
			<?php echo $this->element('menuProgression') ?>
	    <?php echo $this->element('menuMateriels') ?>
			<?php echo $this->element('menuSuivis') ?>
	    <?php echo $this->element('menuEvaluations') ?>
	    <?php echo $this->element('menuAnalyse') ?>
		</ul>
		<ul class ="nav navbar-nav navbar-right">
			<?php echo $this->element('menuAdministration') ?>
		</ul>
	</div>
</nav>
	<div class = "container container-fluid">
    <?php echo $this->Flash->render() ?>
    <?php echo $this->fetch('content') ?>
  </div>
<footer>
</footer>
</body>
</html>
