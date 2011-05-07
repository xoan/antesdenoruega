<?php
Moor::setRequestParamPattern('[0-9A-Za-z_-]+');
Moor::setNotFoundCallback('not_found');

Moor::route('/tasks/@task', 'Tasks::@task');

Moor::route('/blocks/:name', 'Blocks::show');
Moor::route('/blocks', 'Blocks::index');
Moor::route('/', 'Welcome::index');

Moor::run();
