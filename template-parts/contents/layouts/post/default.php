<?php
/**
 * Template part for displaying posts
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rising_Bamboo
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;
use RisingBambooTheme\Helper\Tag;

$position = Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_DETAIL_LAYOUT_THUMBNAIL_POSITION);
$sidebar  = Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_DETAIL_LAYOUT_SIDEBAR);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('mx-auto' . ( ( 'on_top' !== $position ) && ( 'none' !== $sidebar ) ? ' max-w-[880px]' : '' ) . ' ' . esc_attr($args['layout'])); ?>>
    <?php do_action('rbb_single_content_before_title'); //phpcs:ignore ?>
	<div class="relative">
		<div class="entry-content mb-[30px]">
			<?php if ( 'on_header' !== $position ) { ?>
				<h1 class="entry-title text-2xl -mt-2 pb-3"><?php echo esc_html(the_title()); ?></h1>
				<?php
				if ( 'post' === get_post_type() ) :
					?>
					<div class="mb-12 font-semibold text-[#909090] text-[10px] uppercase">
						<?php
						if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_DETAIL_SHOW_AUTHOR) ) {
							?>
							<span class="pr-7">
								<i class="rbb-icon-human-user-10 pr-3 text-[13px]"></i>
								<?php echo esc_html__('By ', 'botanica'); ?><?php echo get_the_author(); ?>
							</span>
							<?php
						}
						?>
						<?php
						if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_DETAIL_SHOW_PUBLISH_DATE) ) {
							?>
							<span class="pr-7">
								<i class="rbb-icon-calendar-1 align-text-top leading-3 text-[22px]"></i>
								<span class="pl-2"><?php the_date(); ?></span>
							</span>
							<?php
						}
						?>
					</div>
				<?php endif; ?>
			<?php } ?>
            <?php do_action('rbb_single_content_after_title'); //phpcs:ignore ?>
			<div>
				<div class="post-content"><?php the_content(); ?></div>
				<?php
				if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_DETAIL_SHOW_SOCIAL_SHARE) ) {
					?>
					<div class="social-share mb-[22px]">
						<?php echo do_shortcode('[rbb_social_share popup=no]'); ?>
					</div>
					<?php
				}
				?>
				<?php
				if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_DETAIL_SHOW_TAG) ) {
					$tags_list = get_the_tag_list('', ' ');
					?>
					<div class="tags-link pt-8 pb-[52px] border-t-[1px] border-[color:var(--rbb-breadcrumb-background-color)]">
							<span class="tag-links pr-5 text-xs text-[color:var(--rbb-general-heading-color)]">
								<i class="rbb-icon-tag-2 rotate-[270]" aria-hidden="true"></i>
								<strong class="uppercase"><?php echo esc_html__('Tags :', 'botanica'); ?> </strong>
							</span>
						<?php echo trim($tags_list); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php } ?>
				<?php wp_link_pages(); ?>
			</div>
		</div>
	</div><!-- .entry-content -->
	<!-- If comments are open, or we have at least one comment, load up the comment template. -->
	<?php
	if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_DETAIL_SHOW_COMMENT) && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
	?>
	<footer class="entry-footer hidden">
		<?php Tag::entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
