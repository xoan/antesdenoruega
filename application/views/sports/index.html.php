<?php $tmpl->place('header'); ?>
<h2>Centros deportivos</h2>

<ul>
<?php foreach($sports as $sport): ?>
	<li><a href="<?php echo link_to('Sports::show :id', $sport->getId()); ?>"><?php echo $sport->getName(); ?></a></li>
<?php endforeach; ?>
</ul>

<p>
	<a href="<?php echo link_to('Welcome::index'); ?>">Inicio</a>
</p>
<?php $tmpl->place('footer'); ?>
