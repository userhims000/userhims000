<?php
namespace Nelio_AB_Testing\Experiment_Library\JavaScript_Experiment;

defined( 'ABSPATH' ) || exit;

add_filter( 'nab_nab/javascript_should_trigger_page_view', '__return_true' );
