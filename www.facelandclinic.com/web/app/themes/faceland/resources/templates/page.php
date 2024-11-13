<?php
$data = Timber::get_context();

$page_template = rokit_get_page_template();

rokit_render_twig('page', $page_template, $data );
?>

