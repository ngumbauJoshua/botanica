<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Rising_Bamboo
 */

use RisingBambooCore\Helper\Helper;
use RisingBambooTheme\App\App;
use RisingBambooTheme\App\Menu\Menu;
use RisingBambooTheme\Helper\Setting;
use RisingBambooTheme\Helper\Tag;

if ( function_exists('elementor_theme_do_location') ) {
	elementor_theme_do_location('footer');
} elseif ( Helper::elementor_activated() ) {
	if ( ! Elementor\Plugin::instance()->preview->is_preview_mode() ) {
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display(Tag::get_footer());
	}
} else {
	get_template_part('template-parts/footers/' . Tag::get_footer());
}
?>
</div><!-- #page -->
<div class="canvas-overlay absolute inset-0 opacity-0 duration-300 invisible"></div>
<div class="canvas-overlay2 absolute inset-0 opacity-0 duration-300 invisible"></div>
<div class="filter-overlay absolute inset-0 opacity-0 duration-300 invisible"></div>
<div id="mobile_menu" class="canvas-menu"></div>
<?php wp_footer(); ?>
</body>
</html>
