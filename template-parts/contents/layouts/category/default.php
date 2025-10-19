<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Rising_Bamboo
 */

use RisingBambooTheme\Helper\Setting;
use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Tag;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-wrap overflow-hidden p-[15px] rounded-[18px] border duration-300 hover:shadow-[5px_5px_10px_rgba(0,0,0,0.08)]">
		<div class="overflow-hidden rounded-[18px]">
			<?php Tag::post_thumbnail(); ?>
		</div>
		<div class="relative">
			<?php
			if ( 'post' === get_post_type() ) :
				?>
				<div class="pt-5 font-semibold text-[#909090] text-[10px] uppercase">
					<?php if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_CATEGORY_SHOW_AUTHOR) ) { ?>
						<span class="pr-7">
							<i class="rbb-icon-human-user-10 pr-3 text-[13px]"></i>
							<?php echo esc_html__('By ', 'botanica'); ?><?php echo get_the_author(); ?>
						</span>
					<?php } ?>
					<?php if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_CATEGORY_SHOW_PUBLISH_DATE) ) { ?>
						<span class="pr-7">
							<i class="rbb-icon-calendar-1 align-text-top leading-3 text-[22px] pr-2"></i>
							<?php echo get_the_date(); ?>
						</span>
					<?php } ?>
					<?php if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_CATEGORY_SHOW_COMMENT_COUNT) ) { ?>
						<span class="comments-link inline-flex">
							<span class="pr-2 flex">
								<svg fill="none" height="14" width="14" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g fill="#909090"><path d="m12 22.81c-.69 0-1.34-.35-1.8-.96l-1.5-2c-.03-.04-.15-.09-.2-.1h-.5c-4.17 0-6.75-1.13-6.75-6.75v-5c0-4.42 2.33-6.75 6.75-6.75h8c4.42 0 6.75 2.33 6.75 6.75v5c0 4.42-2.33 6.75-6.75 6.75h-.5c-.08 0-.15.04-.2.1l-1.5 2c-.46.61-1.11.96-1.8.96zm-4-20.06c-3.58 0-5.25 1.67-5.25 5.25v5c0 4.52 1.55 5.25 5.25 5.25h.5c.51 0 1.09.29 1.4.7l1.5 2c.35.46.85.46 1.2 0l1.5-2c.33-.44.85-.7 1.4-.7h.5c3.58 0 5.25-1.67 5.25-5.25v-5c0-3.58-1.67-5.25-5.25-5.25z"/><path d="m12 12c-.56 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.44 1-1 1z"/><path d="m16 12c-.56 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.44 1-1 1z"/><path d="m8 12c-.56 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.44 1-1 1z"/></g></svg>
							</span>
							<?php
							$comment_count = wp_count_comments(get_the_ID())->total_comments;
							if ( $comment_count > 0 ) {
								?>
								<?php if ( 1 === $comment_count ) { ?>
									<?php echo esc_attr($comment_count) . '<span>' . esc_html_e('Comment', 'botanica') . '</span>'; ?>
								<?php } else { ?>
									<?php echo esc_attr($comment_count) . '<span>' . esc_html__(' Comments', 'botanica') . '</span>'; ?>
								<?php } ?>
							<?php } else { ?>
								<?php echo esc_attr($comment_count) . '<span>' . esc_html__(' Comments', 'botanica') . '</span>'; ?>
							<?php } ?>
						</span>
					<?php } ?>
				</div>
			<?php endif; ?>
			<div class="entry-content">
				<h3 class="entry-title text-[18px] pt-4 pb-2 leading-8"><a class="line-clamp-2 min-h-[64px]" href="<?php echo esc_url(the_permalink()); ?>"><?php echo esc_html(the_title()); ?></a></h3>
				<?php if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_BLOG_CATEGORY_SHOW_EXCERPT) ) { ?>
					<div>
						<?php echo esc_html(wp_trim_words(get_the_content(), 28, '...')); ?>
					</div>
				<?php } ?>
				<div class="mt-5 mb-6">
					<a href="<?php echo esc_url(the_permalink()); ?>" class="blog-readmore text-[#bebebe] hover:text-[color:var(--rbb-general-primary-color)] font-semibold relative mt-6 mb-4"><span class="mr-1.5 relative"><?php echo esc_html__('Read more', 'botanica'); ?></span><i class="rbb-icon-direction-711 top-[1px] relative"></i></a>
				</div>
			</div>
			<?php wp_link_pages(); ?>
		</div><!-- .entry-content -->
		<footer class="entry-footer hidden">
			<?php Tag::entry_footer(); ?>
		</footer><!-- .entry-footer -->
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

