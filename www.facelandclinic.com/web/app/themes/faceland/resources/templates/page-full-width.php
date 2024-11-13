<?php
/*
Template Name: Fullwidth Template
*/
?> 
<?php
$data = Timber::get_context();
rokit_render_twig('page', 'full-width', $data );
?>
