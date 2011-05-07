<?php
Moor::setRequestParamPattern('[0-9A-Za-z_-]+');
Moor::setNotFoundCallback('not_found');

Moor::route('/tasks/@task', 'Tasks::@task');

Moor::route('/barrios/:name', 'Blocks::show');
Moor::route('/barrios', 'Blocks::index');
Moor::route('/', 'Welcome::index');

Moor::run();
