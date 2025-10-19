<?php
/**
 * The default footer.
 *
 * @package Rising_Bamboo
 */

use RisingBambooTheme\App\App;

?>

<footer id="colophon" class="site-footer">
	<div class="site-info">
		<a href="<?php echo esc_url(__('https://wordpress.org/', 'botanica')); ?>">
			<?php
			/* translators: %s: CMS name, i.e. WordPress. */
			printf(esc_html__('Proudly powered by %s', 'botanica'), 'WordPress');
			?>
		</a>
		<span class="sep"> | </span>
		<?php
		/* translators: 1: Theme name, 2: Theme author. */
		printf(esc_html__('Theme: %1$s by %2$s.', 'botanica'), '<a href="https://risingbamboo.com">Rising Bamboo</a>'); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
