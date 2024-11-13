<?php
namespace Deployer;

system('chown root:root ~/.ssh/config');
system('chown root:root ~/.ssh/id_bastion_rsa');
system('chown root:root ~/.ssh/id_faceland_deployment_rsa');

system('chmod 0644 ~/.ssh/config');
system('chmod 0600 ~/.ssh/id_bastion_rsa');
system('chmod 0600 ~/.ssh/id_faceland_deployment_rsa');

require 'recipe/wordpress.php';

set(
    'shared_dirs',
    [
        'web/app/assets',
        'web/app/mu-plugins/wp-caveo-cache',
    ]
);
set(
    'writable_dirs',
    [
        'web/app/assets',
    ]
);
set('shared_files', [
    '.env',
    'web/.htaccess',
    'web/app/mu-plugins/wp-caveo-cache.php',
    'web/robots.txt'
]);
set('exclude', [
    'deploy.php',
    'docker',
    'docker-compose.yml'
]);

// Set configurations
set('repository', 'git@bitbucket.org:enmassebv/www.facelandclinic.com.git');
set('bin_php', '/usr/local/php73/bin/php');
set('keep_releases', 2);
set('http_user', 'facelandcliniccom');

// Configure servers
host('facelandclinic-dev')
    ->stage('dev')
    ->user('www')
    ->identityFile('~/.ssh/id_faceland_deployment_rsa')
    ->set('branch', 'latestphp_changes')
    ->set('environment', 'development')
    ->set('deploy_path', '/var/www/dev.facelandclinic.com/');
    
task(
    'deploy:set:permissions',function(){
        run('chmod -R 777 {{deploy_path}}/current/web/app/themes/faceland/app/customfields');
    }
);

//
//
//host('facelandcloud')
//    ->stage('cloud-production')
//    ->identityFile('~/.ssh/id_rsa')
//    ->set('branch', 'Trello_#_135_php_8_upgradation')
//    ->set('environment', 'prod')
//    ->set('deploy_path', '/var/www/faceland.caveo.cloud/');


host('facelandclinic-staging')
   ->stage('staging')
   ->user('www')
   ->identityFile('~/.ssh/id_faceland_deployment_rsa')
   ->set('branch', 'latestphp_changes')
   ->set('environment', 'staging')
   ->set('deploy_path', '/var/www/staging.facelandclinic.com/');

host('facelandclinic-prd')
    ->stage('production')
    ->user('facelandcliniccom')
    ->identityFile('~/.ssh/id_rsa')
    ->set('branch', 'latestphp_changes')
    ->set('environment', 'prod')
    ->set('deploy_path', '/var/www/www.facelandclinic.com/');

task(
    'deploy:set_permissions', function () {
    run('chmod -R 777 {{deploy_path}}/current/web/app/themes/faceland/app/customfields');
}
);

task(
    'facelandcloud:cache:enable', function () {
    run('sudo /usr/local/bin/cache_enable.sh');
}
);
task(
    'facelandcloud:cache:disable', function () {
    run('sudo /usr/local/bin/cache_disable.sh');
}
);


// Clear cache
task(
    'deploy:cache:clear', function () {
        if (get('stage') === 'dev') {
            run('sudo /usr/sbin/service nginx reload');
            run('sudo /bin/systemctl reload php81-php-fpm');
        } elseif (get('stage') === 'staging') {
            run('sudo /usr/sbin/service nginx reload');
                run('sudo /bin/systemctl reload php72-php-fpm');
        } elseif (get('stage') === 'production') {
                run('sudo /usr/sbin/service php80-php-fpm restart');
        }
});




after('deploy', 'deploy:cache:clear');
after('deploy:cache:clear', 'deploy:set:permissions');
