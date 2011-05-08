<?php $tmpl->place('header'); ?>
<h2>Entrar</h2>

<form method="post" action="<?php link_to('Sessions::create'); ?>">
	<?php fMessaging::show('error', link_to('Sessions::create')); ?>
	<p>
		<label for="user-name">Usuario</label>
		<input type="text" name="name" id="user-name" value="<?php echo fRequest::encode('name'); ?>" />
	</p>
	
	<p>
		<label for="user-password">Contrasinal</label>
		<input type="password" name="password" id="user-password" value="<?php echo fRequest::encode('password'); ?>" />
	</p>
	
	<p>
		<input type="submit" value="Entrar" />
	</p>
</form>

<p>
	<a href="<?php echo link_to('Welcome::index'); ?>">Inicio</a>
</p>
<?php $tmpl->place('footer'); ?>
