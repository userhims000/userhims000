<?php
$taxonomy = get_queried_object();

$data = Timber::get_context();
rokit_render_twig('taxonomy', get_query_var('taxonomy'), $data );
?>
