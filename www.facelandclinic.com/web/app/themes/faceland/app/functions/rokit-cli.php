<?php
/**
 * An awesome function thats makes development easier

 *  wp rokit install
 *  wp rokit install --db to also pull the database with migrated db
 */
function rokit_install( $args, $assoc_args ) {
    //Check if we need to install

    $command = !empty($args[0]) ? $args[0] : '';

    $commands = [
      'install',
      'migrate-database',
      'db'
    ];

    if (!in_array($command, $commands)){
        WP_CLI::error( 'Try using wp rokit install or wp rokit install --db or wp rokit migrate-database or wp rokit db');
        return;
    }

    if ($command == 'install'){
        // Set a few default vars
        $root_dir_path = rokit_root_dir_path();
        $root_dir = "cd " . $root_dir_path;
        $composer_install = "composer install";
        $theme_dir = "cd " . get_template_directory() . " && cd ../";

        // Go to root dir and install composer
        exec( $root_dir ." && " . $composer_install);
        WP_CLI::success( "Runned composer install in root" );

        // Go to theme dir and install composer
        exec($theme_dir . " && " . $composer_install);
        WP_CLI::success( "Runned composer install in theme" );

        // Go to theme dir and install npm
        exec($theme_dir . " && npm install");
        WP_CLI::success( "Runned npm install in theme" );

        // Go to theme dir and run npm run production
        exec($theme_dir . " && gulp build");
        WP_CLI::success( "Runned gulp build in theme" );

    }

    // Check if db needs to be pulled
    if ((!empty($assoc_args['db']) && $assoc_args['db'] == true) || $command == 'migrate-database' || $command == 'db'){
        rokit_pull_db();
    }

    WP_CLI::success( 'All done success coding' );
};

if ( class_exists( 'WP_CLI' ) ) {
    WP_CLI::add_command('rokit', 'rokit_install');
}

/**
 * Run WP_CLI command for activating all plugins
 */
function rokit_active_all_plugins(){
    //Active all wp plugins.
    exec("wp plugin activate --all");
    WP_CLI::success( "Activated all plugins" );
}


function rokit_pull_db(){
    rokit_active_all_plugins();

    //Get the settings of the env file
    Env::init();
    $dotenv = new Dotenv\Dotenv(rokit_root_dir_path());

    if (file_exists(rokit_root_dir_path() . '/.env')) {
        $dotenv->load();
        $dotenv->required(['MIGRATE_DB_SECRET', 'MIGRATE_DB_PULL_URL']);
    }

    $pull_secret = env('MIGRATE_DB_SECRET');
    $pull_url   = env('MIGRATE_DB_PULL_URL');

    //Check if MIGRATE_DB_SECRET is not empty
    if (empty($pull_secret)){
        WP_CLI::success( 'The MIGRATE_DB_SECRET setting is not filled ' );
        return;
    }

    //Check if MIGRATE_DB_PULL_URL is not empty
    if (empty($pull_url)){
        WP_CLI::success( 'The MIGRATE_DB_PULL_URL setting is not filled ' );
        return;
    }

    // Pull the database with migrate DB
    echo shell_exec( "wp migratedb pull " . $pull_url ." " . $pull_secret . " --media=compare");

    WP_CLI::success( 'Database is pulled' );

    //Reactive the plugins because after the pull they might be disabeld
    rokit_active_all_plugins();
    echo shell_exec( "wp rewrite flush");
    WP_CLI::success( 'Flush permalinks' );
}

/**
 * Run WP_CLI command for activating all plugins
 */
function rokit_root_dir_path(){
    return ABSPATH . "../../";
}
