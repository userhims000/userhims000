<?php
$data = Timber::get_context();
rokit_render_twig('single', get_query_var('post_type'), $data );
?>
