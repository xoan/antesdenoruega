<?php $tmpl->place('header'); ?>
<h2>Barrios</h2>

<ul>
<?php foreach($blocks as $block): ?>
	<li><a href="<?php echo link_to('Blocks::show :name', $block->getFriendlyName()); ?>"><?php echo $block->getName(); ?></a></li>
<?php endforeach; ?>
</ul>

<p>
	<a href="<?php echo link_to('Welcome::index'); ?>">Inicio</a>
</p>
<?php $tmpl->place('footer'); ?>
