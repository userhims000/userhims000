<?php
/*
Template Name: Custom Template
*/
?>

<?php
$data = Timber::get_context();
rokit_render_twig('page', 'custom', $data );
?>

