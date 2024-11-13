<?php
/*
Template Name: New Default Template
*/
?>
<?php
$data = Timber::get_context();
rokit_render_twig('page', 'new-default', $data );
?>
