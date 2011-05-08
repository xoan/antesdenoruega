<!DCOTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Antes de Noruega</title>
</head>
<body>
	<h1>Antes de Noruega</h1>
	
	<ul>
		<?php if (fAuthorization::checkLoggedIn()): ?>
			<li><a href="<?php echo link_to('Users::edit'); ?>"><?php echo fAuthorization::getUserToken(); ?></a></li>
			<li><a href="<?php echo link_to('Sessions::destroy') ?>">Saír</a></li>
		<?php else: ?>
			<li><a href="<?php echo link_to('Sessions::create'); ?>">Iniciar sesión</a></li>
			<li><a href="<?php echo link_to('Users::create') ?>">Crear unha conta</a></li>
		<?php endif; ?>
	</ul>
