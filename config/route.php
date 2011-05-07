<?php
Moor::setNotFoundCallback('not_found');

Moor::route('/tasks/@task', 'Tasks::@task');
Moor::route('/', 'Welcome::index');

Moor::run();
