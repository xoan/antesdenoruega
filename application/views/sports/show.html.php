<?php $tmpl->place('header'); ?>
<h2><?php echo $sport->getName(); ?></h2>

<p>
	<img src="http://maps.google.com/maps/api/staticmap?size=300x300&markers=<?php echo $marker; ?>&path=weight:2|color:0xFF9900FF|fillcolor:0xFF990066|<?php echo $path; ?>&sensor=false" width="300" height="300" />
</p>

<p>
	<a href="<?php echo link_to('Sports::index'); ?>">Centros deportivos</a>
</p>
<?php $tmpl->place('footer'); ?>
