<?php $tmpl->place('header'); ?>
<h2>Editar conta</h2>

<form method="post" action="<?php link_to('Users::edit'); ?>">
	<?php fMessaging::show('error', link_to('Users::edit')); ?>
	<p>
		<label for="user-name">Usuario</label>
		<input type="text" disabled="disabled" id="user-name" value="<?php echo $user->encodeName(); ?>" />
	</p>
	
	<p>
		<label for="user-password">Contrasinal</label>
		<input type="password" name="password" id="user-password" />
	</p>
	
	<p>
		<label for="user-email">Correo electrónico</label>
		<input type="text" name="email" id="user-email" value="<?php echo $user->encodeEmail(); ?>" />
	</p>
	
	<p>
		<label for="user-block">Barrio</label>
		<select name="block_id" id="user-block">
			<?php foreach ($blocks as $block): ?>
				<?php fHTML::printOption($block->prepareName(), $block->getId(), $user->createBlock()->getId()); ?>
			<?php endforeach; ?>
		</select>
	</p>
	
	<p>
		<input type="submit" value="Editar" />
	</p>
</form>

<p>
	<a href="<?php echo link_to('Welcome::index'); ?>">Inicio</a>
</p>
<?php $tmpl->place('footer'); ?>
