<?= $this->Html->docType('html5') ?>
<head>
	<title>SPIE: Suivi et Progression Individuelle des Elèves:<?= $this->fetch('title') ?></title>

	<?= $this->Html->charset() ?>

	<?= $this->Html->meta('icon') ?>

	<?= $this->Html->meta(
		'viewport',
		'width=device-width, initial-scale=1'
	); ?>

    <?= $this->Html->css([
		'jquery.dataTables.min.css',
        'bootstrap.min.css',
        'all.css', //fontawesome
        'bootstrap-select.css',
        'custom',
        //'../easyui/themes/default/easyui.css',
        //'../easyui/themes/icon.css'
      ]) ?>

      <?= $this->Html->script([
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
          <a class="navbar-brand" href="#">SPIE</a>
        </div>
	</div>
</nav>
	<div class = "container container-fluid">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
