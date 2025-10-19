<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

use RisingBambooCore\App\App;
use RisingBambooCore\Helper\Woocommerce as RbbCoreHelperWoocommerce;
use RisingBambooTheme\Helper\Setting;
use RisingBambooTheme\Helper\Tag;

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if ( empty($product) || ! $product->is_visible() ) {
	return;
}
$show_wishlist    = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_WISHLIST);
$show_rating      = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_RATING);
$show_quick_view  = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_QUICK_VIEW);
$show_compare     = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_COMPARE);
$show_add_to_cart = Setting::get(RISING_BAMBOO_KIRKI_SECTION_WOOCOMMERCE_PRODUCT_CATALOG_PRODUCT_ITEM_SHOW_ADD_TO_CART);
?>

<div class="item md:px-[15px] px-1.5 !flex justify-center h-auto">
	<div class="item-product relative rounded-[18px] w-full">
		<div class="bg-product absolute w-full h-full -z-10 rounded-[18px] duration-300"></div>
		<div class="relative product-content h-full flex items-start flex-col overflow-hidden border rounded-2xl bg-white">
			<div class="thumbnail-container relative center">
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
					if ( RbbCoreHelperWoocommerce::get_gallery_image($product, [ 600, 600 ]) ) {
						$second_image = RbbCoreHelperWoocommerce::get_gallery_image($product, [ 600, 600 ])[0];
						?>
					<img class="max-w-full image-cover absolute left-0 top-0 opacity-0" src="<?php echo esc_attr($second_image->src); ?>" alt="<?php echo esc_html__('Second image of ', 'botanica') . esc_attr($product->get_name()); ?>"/>
						<?php
					}
					?>
			</a>
			<?php if ( $show_wishlist ) { ?>
				<div class="wishlist absolute md:top-5 top-3 md:right-5 right-3">
					<?php echo Tag::wish_list_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</div>
				<?php
			}
			$countdown_date_to = $product->get_date_on_sale_to();
			if ( $countdown_date_to ) {
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
		<div class="product_title w-full md:pl-7 xl:pr-16 md:pr-3 mt-3">
			<div class="pt-3 md:px-0 px-3">
			<?php if ( $show_rating ) { ?>
				<div class="product_ratting text-amber-400 flex items-center mb-3.5">
					<?php echo wc_get_rating_html($product->get_average_rating()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<span class="ratting-count font-medium ml-1 text-[#5e5e5e] text-[10px]">(<?php echo wp_kses($product->get_rating_count(), 'rbb-kses'); ?>)</span>
				</div>
			<?php } ?>
				<a href="<?php echo esc_url($product->get_permalink()); ?>" class="product_name line-clamp-2 block xl:text-base text-[0.8125rem] font-bold md:mb-6 mb-2"><?php echo wp_kses_post($product->get_name()); ?></a>
			</div>
		</div>
		<div class="product_info w-full mt-auto md:pl-7 xl:pr-16 md:pr-3 mt-3 xl:pb-9 pb-6 relative">
			<div class="product_info-bottom bg-white md:px-0 px-3">
				<?php if ( $show_wishlist ) { ?>
					<div class="wishlist absolute hidden -md:top-2 top-2 right-5">
						<?php echo Tag::wish_list_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php } ?>
				<?php if ( $show_rating ) { ?>
					<div class="product_ratting hidden text-amber-400 flex items-center mb-3.5">
						<?php echo wc_get_rating_html($product->get_average_rating()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<span class="ratting-count font-medium ml-1 text-[#5e5e5e] text-[10px]">(<?php echo wp_kses($product->get_rating_count(), 'rbb-kses'); ?>)</span>
					</div>
				<?php } ?>
				<a href="<?php echo esc_url($product->get_permalink()); ?>" class="product_name block hidden md:text-base text-[0.8125rem] font-bold md:mb-6 mb-4"><?php echo wp_kses_post($product->get_name()); ?></a>
				<div class="product_price text-sm font-extrabold">
					<?php echo wp_kses($product->get_price_html(), 'rbb-kses'); ?>
				</div>
				<div class="short_description hidden pt-[22px] mb-6 leading-6">
					<?php echo esc_html(wp_trim_words($product->get_short_description(), 28, '...')); ?>
				</div>
			</div>
			<div class="product_button absolute md:right-5 md:left-auto left-3 xl:bottom-7 md:bottom-4 bottom-3">
				<?php
				if ( $show_quick_view ) {
					echo Tag::quick_view_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
				<?php
				if ( $show_compare ) {
					echo Tag::compare_button($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
				<?php
				if ( $show_add_to_cart ) {
					$args       = [];
					$text_cart  = '';
					$click_cart = '';
					$icon       = Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_MINI_CART_ICON);
					if ( 'instock' !== $product->get_stock_status() ) {
						$text_cart = esc_html__('Out of stock', 'botanica');
					} else {
						if ( $product instanceof \WC_Product_Variable && $product->get_available_variations() ) {
							$text_cart = esc_html__('Select options', 'botanica');
						} else {
							$text_cart = esc_html__('Add to Cart', 'botanica');
						}
					}
					if ( $icon ) {
						$args['cart-icon'] = '<div class="add-to-cart-icon relative text-center leading-10 ' . $click_cart . '">
						<span class="title-tooltips absolute whitespace-nowrap opacity-0 text-white">' . $text_cart . '</span>
						<i class="rbb-icon ' . $icon . '"></i>
						</div>';
					}
					woocommerce_template_loop_add_to_cart($args);
				}
				?>
			</div>
		</div>
	</div>
</div>
</div>
