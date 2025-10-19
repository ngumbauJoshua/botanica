<?php
/**
 * Elementor widget : woo-product.
 *
 * @package RisingBambooTheme
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Tag;

?>
<div class="item">
	<div class="item-product relative overflow-hidden lg:flex justify-center items-center">
		<div class="lg:w-1/2 thumbnail-container relative center ">
			<a class="relative block overflow-hidden" href="<?php echo esc_url($product->get_permalink()); ?>">
				<?php
				echo wp_kses(
					$product->get_image(
						[ 640, 640 ],
						[
							'class' => 'max-w-full w-full',
							'alt'   => esc_attr($product->get_name()),
						]
					),
					'rbb-kses'
				);
				if ( \RisingBambooCore\Helper\Woocommerce::get_gallery_image($product, [ 640, 640 ]) ) {
					$second_image = \RisingBambooCore\Helper\Woocommerce::get_gallery_image($product, [ 640, 640 ])[0];
					?>
					<img class="max-w-full image-cover absolute left-0 top-0 opacity-0" src="<?php echo esc_attr($second_image->src); ?>" alt="<?php echo esc_html__('Second image of ', 'botanica') . esc_attr($product->get_name()); ?>"/>
					<?php
				}
				?>
			</a>
			<?php if ( $show_wishlist ) { ?>
				<div class="absolute top-5 right-5 tracking-normal">
					<?php echo Tag::wish_list_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
			<?php } ?>
			<div class="product-flags absolute left-4 top-5 z-10 font-semibold text-[11px]">
				<?php
				if ( $show_percentage_discount && $product->get_sale_price() ) {
					$regular_price   = $product->get_regular_price();
					$sale_price      = $product->get_sale_price();
					$sale_percentage = 100 - round(( $sale_price / $regular_price ) * 100);
					?>
					<label class="bg-[#d4ff6e] text-[#222] py-1 px-[13px] rounded-[26px] flex leading-[18px] items-center mb-2.5 h-[26px] text-center min-w-[66px]"><i
								class="rbb-icon-flash-1 mr-[1px] text-xs"></i>
						<?php echo '-' . esc_html($sale_percentage) . '%'; ?>
					</label>
				<?php } ?>
				<?php if ( $product->is_featured() && 'instock' === $product->get_stock_status() ) { ?>
					<label class="bg-[#66ad53] text-white font-bold py-[5px] leading-[18px] px-[13px] text-[10px] h-[26px] rounded-[26px] block mb-2.5 uppercase text-center min-w-[66px]"><?php echo esc_html__('New', 'botanica'); ?>
					</label>
				<?php } ?>
				<?php if ( 'instock' !== $product->get_stock_status() ) { ?>
					<label class="bg-[#66ad53] text-white font-bold py-[5px] px-[13px] leading-[18px] text-[10px] h-[26px] rounded-[26px] block mb-2.5 uppercase text-center min-w-[66px]"><?php echo esc_html__('Sold out', 'botanica'); ?>
					</label>
				<?php } ?>
			</div>
			<?php
			$countdown_date_to = $product->get_date_on_sale_to();
			if ( $show_countdown && $countdown_date_to ) {
				$current_date         = new \WC_DateTime();
				$countdown_date_start = $product->get_date_on_sale_from() ?? $product->get_date_modified();
				if ( ( $current_date >= $countdown_date_start ) && ( $current_date <= $countdown_date_to ) ) {
					?>
					<div class="item-countdown absolute md:inset-x-[30px] inset-x-1 bottom-3.5 duration-300">
						<div class="rbb-countdown flex justify-center relative" data-countdown-date="<?php echo esc_attr($countdown_date_to->format('Y/m/d')); ?>">
							<div class="item-time"><span class="data-number">%D</span><span class="name-time"><?php echo esc_html__('Day%!H', 'botanica'); ?></span></div>
							<div class="item-time"><span class="data-number">%H</span><span class="name-time"><?php echo esc_html__('Hour%!H', 'botanica'); ?></span></div>
							<div class="item-time"><span class="data-number">%M</span><span class="name-time"><?php echo esc_html__('Min%!H', 'botanica'); ?></span></div>
							<div class="item-time"><span class="data-number">%S</span><span class="name-time"><?php echo esc_html__('Secs', 'botanica'); ?></span></div>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
		<div class="lg:w-1/2 xl:pl-[95px] md:pl-7 product_info relative">
			<?php if ( $show_rating ) { ?>
				<div class="product_ratting text-amber-400 flex items-center mb-3.5">
					<?php echo wc_get_rating_html($product->get_average_rating()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="ratting-count text-[#5e5e5e] font-medium ml-1 text-[10px]">(<?php echo esc_html($product->get_rating_count()); ?>)</span>
				</div>
			<?php } ?>
			<a href="<?php echo esc_url($product->get_permalink()); ?>" class="product_name block xl:text-2xl mb-7"><?php echo wp_kses_post($product->get_name()); ?></a>
			<div class="product_price md:text-[30px] text-lg font-extrabold">
				<?php echo wp_kses($product->get_price_html(), 'rbb-kses'); ?>
			</div>
			<div class="short_description mt-7 text-base mb-6 leading-6"><?php echo wp_kses_post($product->get_short_description()); ?></div>
			<div class="product_button">
				<?php
				$checkout_url = wc_get_checkout_url();
				if ( $show_add_to_cart ) {
					?>
					<div class="bottom-buy-now inline-flex font-bold text-xs text-center relative">
						<div class="buy-now duration-300 pr-[5px]">
							<?php
							if ( $product->is_type('simple') ) {
								echo '<a class="z-[2] button text-white hover:text-[color:var(--rbb-general-primary-color)] duration-300 bg-[color:var(--rbb-general-primary-color)] hover:bg-white border border-[color:var(--rbb-general-primary-color)] h-14 leading-[56px] rounded-[56px] md:min-w-[160px] min-w-[140px] px-5 block" href="' . esc_attr($checkout_url) . '?add-to-cart=' . esc_attr($product->get_id()) . '">' . esc_html__('Buy Now', 'botanica') . '</a>';
							} else {
								?>
								<a class="disabled button opacity-60 cursor-default pointer-events-none z-[2] text-white hover:text-[color:var(--rbb-general-primary-color)] duration-300 bg-[color:var(--rbb-general-primary-color)] hover:bg-white border border-[color:var(--rbb-general-primary-color)] h-14 leading-[56px] rounded-[56px] md:min-w-[160px] min-w-[140px] px-5 block" href="<?php echo esc_url($product->get_permalink()); ?>">
									<?php echo esc_html__('Buy Now', 'botanica'); ?>
								</a>
							<?php } ?>
						</div>
						<?php
						if ( $show_quickview ) {
							echo Tag::quick_view_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						if ( $show_compare ) {
							echo Tag::compare_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						}
						?>
						<div class="learn-more button duration-300 pr-[5px]">
							<a class="h-14 leading-[56px] rounded-[56px] min-w-[160px] px-5 block z-[2] duration-300 text-[color:var(--rbb-general-primary-color)] hover:text-white border border-[color:var(--rbb-general-primary-color)] hover:bg-[color:var(--rbb-general-primary-color)]" href="<?php echo esc_url($product->get_permalink()); ?>">
								<?php echo esc_html__('Learn more', 'botanica'); ?>
							</a>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
