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

// Tasks
task('artisan:cache:clear', function () {
    run('{{bin/php}} {{release_path}}/artisan cache:clear');
    run('{{bin/php}} {{release_path}}/artisan config:clear');
    run('{{bin/php}} {{release_path}}/artisan route:clear');
    run('{{bin/php}} {{release_path}}/artisan view:clear');
});

// Add the logs:access task
// This task now points to Nginx's default access log location
task('logs:access', function () {
    run('tail -f /var/log/nginx/access.log');
});

// Add copy .env
task('deploy:shared', function (){
    upload('.env', '{{deploy_path}}/shared/.env');  
});
task('deploy:symlink', function () {
    run('ln -nfs {{deploy_path}}/shared/.env {{deploy_path}}/current/.env');
});

after('deploy:symlink', 'artisan:cache:clear');

