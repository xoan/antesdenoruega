<?php $tmpl->place('header'); ?>
<h2>Benvido</h2>

<ul>
	<li><a href="<?php echo link_to('Blocks::index'); ?>">Barrios</a></li>
	<li><a href="<?php echo link_to('Sports::index'); ?>">Centros deportivos</a></li>
</ul>
<?php $tmpl->place('footer'); ?>
