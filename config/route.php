<?php
Moor::setRequestParamPattern('[0-9A-Za-z_-]+');
Moor::setNotFoundCallback('not_found');

Moor::route('/tasks/@task', 'Tasks::@task');

Moor::route('/entrar', 'Sessions::create');
Moor::route('/sair', 'Sessions::destroy');

Moor::route('/conta/crear', 'Users::create');
Moor::route('/conta/editar', 'Users::edit');
Moor::route('/usuarios/:id', 'Users::show');
Moor::route('/usuarios', 'Users::index');

Moor::route('/barrios/:name', 'Blocks::show');
Moor::route('/barrios', 'Blocks::index');
Moor::route('/', 'Welcome::index');

Moor::run();
