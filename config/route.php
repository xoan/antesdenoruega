<?php
Moor::setRequestParamPattern('[0-9A-Za-z_-]+');
Moor::setNotFoundCallback('not_found');

Moor::route('/tasks/@task', 'Tasks::@task');

Moor::route('/entrar', 'Sessions::create');
Moor::route('/sair', 'Sessions::destroy');

Moor::route('/conta/crear', 'Users::create');
Moor::route('/conta/editar', 'Users::edit');

Moor::route('/barrios/:name', 'Blocks::show');
Moor::route('/barrios', 'Blocks::index');

Moor::route('/deportes/:id', 'Sports::show');
Moor::route('/deportes', 'Sports::index');

Moor::route('/', 'Welcome::index');

Moor::run();
