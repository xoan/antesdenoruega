<?php
Moor::setNotFoundCallback('not_found');

Moor::route('/', function() {
	echo 'Antes de Noruega';
});

Moor::run();
