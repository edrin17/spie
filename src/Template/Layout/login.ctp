<?= $this->Html->docType('html5') ?>

<html lang="fr">
<head>
	<title>SPIE: Suivi et Progression Individuelle des Elèves:<?= $this->fetch('title') ?></title>	
	
	<?= $this->Html->charset() ?>   
	
	<?= $this->Html->meta('icon') ?>	
	
	<?= $this->Html->meta(
		'viewport',
		'width=device-width, initial-scale=1'
	); ?>

	<?= $this->Html->css([
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        'jquery.dataTables.min',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/css/bootstrap-select.css',
        'custom',
    ]) ?>
    
	<?= $this->Html->script([
		'https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js', 
		'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.0/js/bootstrap-select.min.js',
		'jquery.dataTables.min'
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
