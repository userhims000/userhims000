<?php
$post_types=get_post_types('','objects');

$args = array(
	"post_type" => "page",
	"posts_per_page" => -1
);

// Make this work for Polylang translation plugin
if( function_exists( 'pll_default_language' ) ) {
    $current_lang = pll_default_language();

    if( !empty( $current_lang ) ) {
        $args['lang'] = $current_lang;
    }
}

$pages = get_posts( $args );

$load_pages = array();
if( $pages ) {
	foreach ($pages as $page) {

		global $sitepress;

		$page_id = $page->ID;

		// Make this work for WPML translation plugin
		if( function_exists('icl_object_id') && !empty($sitepress) ) {

			$lang_id = icl_object_id( $page->ID, 'page', false, $sitepress->get_default_language());

			if( $lang_id == $page_id ) {
				$load_pages[] = $page;
			}

		// Make this work for Polylang translation plugin
		} else if( function_exists('pll_get_post') ) {

            $lang_id = pll_get_post( $page->ID, pll_default_language() );

			if( $lang_id == $page_id ) {
				$load_pages[] = $page;
			}

		} else {
			$load_pages[] = $page;
		}
	}
}
?>

<div class="wrap">
	<div id="icon-options-general" class="icon32"><br></div>
	<div class="title-wrapper">
		<h2> <?php echo __('Rodesk Metabox Tabs','umt'); ?> </h2><p>v<?php echo $this->version; ?></p>
	</div>

	<div class="clearfix"></div>
	<h2 class="nav-tab-wrapper">
		<a href="" class="nav-tab nav-tab-active"><?php echo __('General','umt'); ?></a>
		<a href="<?php echo add_query_arg('subpage', 'extension' , $this->menu_url); ?>" class="nav-tab"><?php echo __('Extensions','umt'); ?></a>
		<a href="<?php echo add_query_arg('subpage', 'patcher' , $this->menu_url); ?>" class="nav-tab"><?php echo __('Patches','umt'); ?></a>
	</h2>

	<table class="wp-list-table widefat fixed posts" cellspacing="0">
	<thead>
		<tr>
			<th scope="col" id="cb" class="manage-column column-cb check-column" style=""><input type="checkbox"></th><th scope="col" id="title" class="manage-column column-title sortable desc" style=""><span><?php echo __('Title','umt'); ?></span></th>
			<th scope="col" id="date" class="manage-column column-date sortable asc" style=""><span><?php echo __('Slug','umt'); ?></span></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th scope="col" class="manage-column column-cb check-column" style=""><input type="checkbox"></th><th scope="col" class="manage-column column-title sortable desc" style=""><span><?php echo __('Title','umt'); ?></span></th><th scope="col" class="manage-column column-date sortable asc" style=""><span><?php echo __('Slug','umt'); ?></span></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
		<?php $posttype_url = add_query_arg('options', '1', $this->menu_url); ?>
		<tr valign="top">
			<th scope="row" class="check-column"></th>
			<td class="post-title page-title column-title">
				<strong>
					<a class="row-title" href="<?php echo $posttype_url; ?>" title="Edit"><?php echo __('Global Options','umt'); ?></a>
				</strong>
				<div class="row-actions">
					<span class="edit"><a href="<?php echo $posttype_url; ?>" title="Edit this item"><?php echo __('Edit','umt'); ?></a></span>
				</div>
			</td>
			<td>
				<?php //echo $post_type->name; ?>
			</td>
		</tr>
		<?php foreach ($this->settings_pages as $slug => $settings_page ): ?>
		<?php
			$posttype_url = add_query_arg('settings', $slug, $this->menu_url);
		?>
		<tr valign="top">
			<th scope="row" class="check-column"></th>
			<td class="post-title page-title column-title">
				<strong>
					<a class="row-title" href="<?php echo $posttype_url; ?>" title="Edit"><?php echo $settings_page['name']; ?></a>
				</strong>
				<div class="row-actions">
					<span class="edit"><a href="<?php echo $posttype_url; ?>" title="Edit this item"><?php echo __('Edit','umt'); ?></a></span>
				</div>
			</td>
			<td class="date-title column-author">
				<?php //echo $slug; ?>
			</td>
		</tr>
		<?php endforeach; ?>

		<?php foreach ($post_types as $post_type ): ?>
		<?php if ($this->post_types_ignored($post_type->name)) { continue; } ?>
		<?php
			$posttype_url = add_query_arg('posttype', $post_type->name, $this->menu_url);
		?>
		<tr valign="top">
			<th scope="row" class="check-column"></th>
			<td class="post-title page-title column-title">
				<strong>
					<a class="row-title" href="<?php echo $posttype_url; ?>" title="Edit"><?php echo $post_type->label; ?></a>
				</strong>
				<div class="row-actions">
					<span class="edit"><a href="<?php echo $posttype_url; ?>" title="Edit this item"><?php echo __('Edit','umt'); ?></a></span>
				</div>
			</td>
			<td class="date-title column-author">
				<?php echo $post_type->name; ?>
			</td>
		</tr>
		<?php endforeach; ?>

		<?php foreach ($load_pages as $page ): ?>
		<?php
			$page_url = add_query_arg('page_id', $page->ID, $this->menu_url);
		?>
		<tr valign="top">
			<th scope="row" class="check-column"></th>
			<td class="post-title page-title column-title">
				<strong>
					<a class="row-title" href="<?php echo $page_url; ?>" title="Edit"><?php echo $page->post_title; ?></a>
				</strong>
				<div class="row-actions">
					<span class="edit"><a href="<?php echo $page_url; ?>" title="Edit this item"><?php echo __('Edit','umt'); ?></a></span>
				</div>
			</td>
			<td class="date-title column-author">
				<?php echo $page->post_type; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
