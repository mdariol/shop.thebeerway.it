<?php

namespace Deployer;

require 'recipe/laravel.php';

/* ==========================================================================
 * Config
 * ========================================================================== */

set('application', 'my_project');
set('repository', 'git@github.com:OutlawPlz/shop.thebeerway.it.git');

set('git_tty', true);

set('default_stage', 'stage');

set('release_name', function () {
    return input()->getOption('tag');
});

//add('shared_files', []);
//add('shared_dirs', []);

//add('writable_dirs', []);

/* ==========================================================================
 * Hosts
 * ========================================================================== */

inventory('hosts.yml');

//host('example.com')->user('root')
//  ->set('deploy_path', '/var/www/example.com');

/* ==========================================================================
 * Tasks
 * ========================================================================== */

//option('tag', null, InputOption::VALUE_OPTIONAL, 'Tag to deploy.', function () {
//    runLocally('git describe --tags --abbrev=0');
//});

task('build', function () {
    run('cd {{release_path}} && build');
});

task('check:tag', function () {
    if (empty(input()->getOption('tag'))) {
        throw new \Exception('Please, specify a version to deploy via "--tag" option.');
    }
});

/* ----- After ----- */

after('deploy:failed', 'deploy:unlock');

/* ----- Before ----- */

before('deploy:prepare', 'check:tag');
before('deploy:symlink', 'artisan:migrate');
