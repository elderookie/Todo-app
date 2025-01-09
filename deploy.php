<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'todo-app');

// Config

set('repository', 'https://github.com/elderookie/todo-app.git');
set('deploy_path', '/var/www/todo-app');

add('shared_files', ['.env']);
add('shared_dirs', ['storage']);
add('writable_dirs', []);

// Hosts
host('3.214.41.235')
    ->set('remote_user', 'ec2-user')
    ->set('identity_file', '~/.ssh/Builder2025.pem')
    ->set('deploy_path', '/var/www/todo-app');

// Hooks

after('deploy:failed', 'deploy:unlock');
