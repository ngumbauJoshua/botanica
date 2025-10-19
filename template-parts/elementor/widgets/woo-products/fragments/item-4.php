<?php
/**
 * Elementor widget : woo-product.
 *
 * @package RisingBambooTheme
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;
use RisingBambooTheme\Helper\Tag;
?>
<div class="item">
	<div class="item-product relative border rounded-[18px] bg-white md:flex justify-center items-center">
		<div class="bg-product absolute w-full h-full -z-10 rounded-[18px] duration-300 shadow-[10px_11px_20px_0px_rgba(0,0,0,0.15)]"></div>
		<?php if ( $show_wishlist ) { ?>
			<div class="absolute md:top-5 z-10 top-3 md:right-5 right-3">
				<?php echo Tag::wish_list_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php } ?>
		<div class="md:w-1/2 thumbnail-container rounded-[18px] overflow-hidden relative center">
			<a class="relative block overflow-hidden" href="<?php echo esc_url($product->get_permalink()); ?>">
				<?php
					echo wp_kses(
						$product->get_image(
							[ 600, 600 ],
							[
								'class' => 'max-w-full w-full',
								'alt'   => esc_attr($product->get_name()),
							]
						),
						'rbb-kses'
					);
					if ( \RisingBambooCore\Helper\Woocommerce::get_gallery_image($product, [ 600, 600 ]) ) {
						$second_image = \RisingBambooCore\Helper\Woocommerce::get_gallery_image($product, [ 600, 600 ])[0];
						?>
						<img class="max-w-full image-cover absolute left-0 top-0 opacity-0" src="<?php echo esc_attr($second_image->src); ?>" alt="<?php echo esc_html__('Second image of ', 'botanica') . esc_attr($product->get_name()); ?>"/>
						<?php
					}
					?>
				</a>
				<div class="product-flags absolute md:left-4 left-3 md:top-5 top-3 z-10 font-semibold text-[11px]">
					<?php
					if ( $show_percentage_discount && $product->get_sale_price() ) {
						$regular_price   = $product->get_regular_price();
						$sale_price      = $product->get_sale_price();
						$sale_percentage = 100 - round(( $sale_price / $regular_price ) * 100);
						?>
						<label class="bg-[#d4ff6e] text-[#222] py-1 px-[13px] rounded-[26px] flex leading-[18px] items-center mb-2.5 h-[26px] text-center min-w-[66px]"><i class="rbb-icon-flash-1 mr-[1px] text-xs"></i>
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
		<div class="product-groups bottom-[21px] top-auto opacity-0 absolute duration-300 left-1/2 -translate-x-1/2">
			<div class="flex relative">
			<?php
			if ( $show_add_to_cart ) {
				$args       = [];
				$click_cart = '';
				$icon       = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_MINI_CART_ICON);
				if ( $icon ) {
					$args['cart-icon'] = '<div class="add-to-cart-icon relative text-center mb-1 leading-10">
					<i class="rbb-icon ' . $icon . '"></i>
					</div>';
				}
				woocommerce_template_loop_add_to_cart($args);
			}
			?>
			<?php
			if ( $show_compare ) {
				echo Tag::compare_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
			<?php
			if ( $show_quickview ) {
				echo Tag::quick_view_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			?>
				</div>
			</div>
	</div>
	<div class="md:w-1/2 md:py-4 pt-4 pb-6 md:px-[15px] product_info relative">
		<div class="product_info-bottom bg-white md:px-0 px-3">
			<?php if ( $show_rating ) { ?>
				<div class="product_ratting text-amber-400 flex items-center mb-2.5">
					<?php echo wc_get_rating_html($product->get_average_rating()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="ratting-count text-[#5e5e5e] font-medium ml-1 text-[10px]">(<?php echo esc_html($product->get_rating_count()); ?>)</span>
				</div>
			<?php } ?>
			<a href="<?php echo esc_url($product->get_permalink()); ?>" class="product_name block md:text-base text-[0.8125rem] font-bold md:mb-5 mb-2"><?php echo wp_kses_post($product->get_name()); ?></a>
			<div class="product_price text-lg font-extrabold overflow-hidden">
				<?php echo wp_kses($product->get_price_html(), 'rbb-kses'); ?>
			</div>
			<?php
			$countdown_date_to = $product->get_date_on_sale_to();
			if ( $show_countdown && $countdown_date_to ) {
				$current_date         = new \WC_DateTime();
				$countdown_date_start = $product->get_date_on_sale_from() ?? $product->get_date_modified();
				if ( ( $current_date >= $countdown_date_start ) && ( $current_date <= $countdown_date_to ) ) {
					?>
					<div class="item-countdown -mx-[5px] mt-[30px]">
						<div class="rbb-countdown flex justify-self-end relative" data-countdown-date="<?php echo esc_attr($countdown_date_to->format('Y/m/d')); ?>">
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
		</div>
	</div>
</div>
