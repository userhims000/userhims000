<?php
$data = Timber::get_context();
rokit_render_twig('archive', get_query_var('post_type'), $data );
?>
