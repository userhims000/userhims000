<?php
/*
Template Name: Christmas campaign template
*/
?>
<?php
$data = Timber::get_context();
$data['christmas_panorama'] = [
	'title_tag' => get_field("christmas_title_tag",get_the_ID()),
	'title' => get_field("christmas_panorama_title",get_the_ID()),
	'christmas_animation_bulb_image' => get_field("christmas_animation_bulb_image",get_the_ID()),
	'christmas_discount_save_upto_text' => get_field("christmas_discount_save_upto_text",get_the_ID()),
	'christmas_panorama_description' => get_field("christmas_panorama_description",get_the_ID()),
	'primary_cta' => [
		'label' =>  get_field("christmas_primary_cta_button_label",get_the_ID()),
		'url' =>  get_field("christmas_primary_cta_button_url",get_the_ID()),
		'external' =>  get_field("christmas_primary_cta_button_external",get_the_ID())
	],
	'secondary_cta' => [
		'label' =>  get_field("christmas_secondary_cta_button_label",get_the_ID()),
		'url' =>  get_field("christmas_secondary_cta_button_url",get_the_ID()),
		'external' =>  get_field("christmas_secondary_cta_button_external",get_the_ID())
	],
];
rokit_render_twig('page', 'christmas-campaign-page', $data );
?>
