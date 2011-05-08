<?php $tmpl->place('header'); ?>
<h2>Crear conta</h2>

<form method="post" action="<?php link_to('Users::create'); ?>">
	<?php fMessaging::show('error', link_to('Users::create')); ?>
	<p>
		<label for="user-name">Usuario</label>
		<input type="text" name="name" id="user-name" value="<?php echo $user->encodeName(); ?>" />
	</p>
	
	<p>
		<label for="user-password">Contrasinal</label>
		<input type="password" name="password" id="user-password" value="<?php echo $user->encodePassword(); ?>" />
	</p>
	
	<p>
		<label for="user-email">Correo electrónico</label>
		<input type="text" name="email" id="user-email" value="<?php echo $user->encodeEmail(); ?>" />
	</p>
	
	<p>
		<label for="user-block">Barrio</label>
		<select name="block_id" id="user-block">
			<?php foreach ($blocks as $block): ?>
				<?php fHTML::printOption($block->prepareName(), $block->getId(), fRequest::get('block_id')); ?>
			<?php endforeach; ?>
		</select>
	</p>
	
	<p>
		<input type="submit" value="Crear" />
	</p>
</form>

<p>
	<a href="<?php echo link_to('Welcome::index'); ?>">Inicio</a>
</p>
<?php $tmpl->place('footer'); ?>
