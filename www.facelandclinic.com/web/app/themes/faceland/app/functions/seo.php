<?php
/*
 * Add replacement vars to yoast so multi language works. With these words.
 */

pll_register_string('yoast_replacement', 'Behandelingen');
pll_register_string('yoast_replacement', 'Specialisten');
pll_register_string('yoast_replacement', 'Klinieken');
pll_register_string('yoast_replacement', 'Prijzen');
pll_register_string('yoast_replacement', 'Nieuws');
pll_register_string('yoast_replacement', 'Blog');
pll_register_string('yoast_replacement', 'Updates');
pll_register_string('yoast_replacement', 'Videos');
pll_register_string('yoast_replacement', 'Veel gestelde vragen');
pll_register_string('yoast_replacement', 'Zoeken');
pll_register_string('yoast_replacement', 'Academy');
pll_register_string('yoast_replacement', 'Last Minutes');
pll_register_string('yoast_replacement', 'Surgery days');
pll_register_string('yoast_replacement', 'Acties');
pll_register_string('yoast_replacement', 'Campagnes');
pll_register_string('yoast_replacement', 'Voor en na');

function treatments() {
    return pll__('Behandelingen');
}

function specialists() {
    return pll__('Specialisten');
}

function locations() {
    return pll__('Klinieken');
}

function prices() {
    return pll__('Prijzen');
}

function news() {
    return pll__('Nieuws');
}

function blog() {
    return pll__('Blog');
}

function updates() {
    return pll__('Updates');
}

function videos() {
    return pll__('Videos');
}

function faq() {
    return pll__('Veel gestelde vragen');
}

function search() {
    return pll__('Zoeken');
}

function academy() {
    return pll__('Academy');
}

function lastminutes() {
    return pll__('Last Minutes');
}

function surgerydays() {
    return pll__('Surgery days');
}

function actions() {
    return pll__('Acties');
}

function campaigns() {
    return pll__('Campagnes');
}
function before_and_after() {
    return pll__('Voor en na');
}


function register_custom_yoast_variables() {
    wpseo_register_var_replacement( '%%treatments%%',           'treatments',   'advanced', 'returns treatments in current language' );
    wpseo_register_var_replacement( '%%specialists%%',          'specialists',  'advanced', 'returns specialists in current language' );
    wpseo_register_var_replacement( '%%locations%%',            'locations',    'advanced', 'returns locations in current language' );
    wpseo_register_var_replacement( '%%prices%%',               'prices',       'advanced', 'returns prices in current language' );
    wpseo_register_var_replacement( '%%news%%',                 'news',         'advanced', 'returns news in current language' );
    wpseo_register_var_replacement( '%%blog%%',                 'blog',         'advanced', 'returns blog in current language' );
    wpseo_register_var_replacement( '%%updates%%',              'updates',      'advanced', 'returns updates in current language' );
    wpseo_register_var_replacement( '%%videos%%',               'videos',       'advanced', 'returns videos in current language' );
    wpseo_register_var_replacement( '%%faq%%',                  'faq',          'advanced', 'returns faq in current language' );
    wpseo_register_var_replacement( '%%search%%',               'search',       'advanced', 'returns search in current language' );
    wpseo_register_var_replacement( '%%academy%%',              'academy',      'advanced', 'returns academy in current language' );
    wpseo_register_var_replacement( '%%lastminutes%%',          'lastminutes',  'advanced', 'returns academy in current language' );
    wpseo_register_var_replacement( '%%surgerydays%%',          'surgerydays',  'advanced', 'returns academy in current language' );
    wpseo_register_var_replacement( '%%actions%%',              'actions',      'advanced', 'returns actions in current language' );
    wpseo_register_var_replacement( '%%campaigns%%',            'campaigns',    'advanced', 'returns campaigns in current language' );
    wpseo_register_var_replacement( '%%before_and_after%%',     'before_and_after',    'advanced', 'returns before and after in current language' );
}
// Add action
add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables');
