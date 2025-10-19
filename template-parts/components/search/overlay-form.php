<?php
/**
 * RisingBambooTheme
 *
 * @package RisingBambooTheme.
 */

use RisingBambooTheme\App\App;
use RisingBambooTheme\Helper\Setting;
use RisingBambooCore\Helper\Woocommerce as RisingBambooCoreWoocommerceHelper;

$categories = RisingBambooCoreWoocommerceHelper::get_flat_categories();
$limit      = Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_SEARCH_RESULT_LIMIT);
$class_form = 'rbb-search-form';
if ( Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_SEARCH_AJAX) ) {
	$class_form .= ' rbb-ajax-search';
}
$category_slug = get_query_var('product_cat');
?>

<div id="rbb-search-content" class="style-2 invisible opacity-0 fixed inset-0 px-[15px] transition-all duration-500 bg-white">
	<div class="rbb-search-top max-w-[850px] z-50 mx-auto relative">
		<div onclick="RbbThemeSearch.closeSearchForm(event)" class="close-search relative mt-[74px] mx-auto mb-[100px] w-10 h-10 rounded-full text-center leading-10 cursor-pointer">✕
		</div>
		<div id="_desktop_search">
			<form role="search" method="get" class="<?php echo esc_attr($class_form); ?>" action="<?php echo esc_url(home_url('/')); ?>" data-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" data-noresult="<?php echo esc_html__('No Result', 'botanica'); ?>" data-limit="<?php echo esc_attr($limit); ?>">
				<div class="relative input-group z-20 flex bg-white rounded-[30px]">
					<?php if ( $categories && Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_SEARCH_BY_CATEGORY) ) { ?>
						<div class="rbb-search-categories relative flex-grow h-12">
							<div class="current-category flex items-center h-full w-full inline-block py-2 px-5 cursor-pointer leading-[48px]" onclick="RbbThemeSearch.openSearchCategories(event)">
								<span class="flex-grow font-semibold uppercase text-[11px] whitespace-nowrap">
								<?php
								if ( isset($categories[ $category_slug ]) ) {
									echo wp_kses_post($categories[ $category_slug ]);
								} else {
									echo esc_html__('Category', 'botanica');
								}
								?>
								</span>
								<i class="rbb-icon"></i>
							</div>
							<ul class="categories absolute left-0 top-full z-50 py-2 bg-white rounded-[3px] shadow-lg">
								<li class="dropdown-item cursor-pointer font-bold text-[11px] px-5 py-1.5 active"
									onclick="RbbThemeSearch.chooseCategory(event, '')"><?php echo esc_html__('All Categories', 'botanica'); ?></li>
								<?php foreach ( $categories as $cat_slug => $cat_name ) { ?>
									<li class="dropdown-item cursor-pointer text-[11px] px-5 py-1.5 whitespace-nowrap <?php echo esc_attr(( $cat_slug === $category_slug ) ? 'active' : ''); ?>"
										onclick="RbbThemeSearch.chooseCategory(event,'<?php echo esc_attr($cat_slug); ?>')">
										<?php echo wp_kses_post(str_replace(' ', '-', $cat_name)); ?>
										</li>
								<?php } ?>
							</ul>
							<input type="hidden" name="product_cat" class="product-cat" value="<?php echo esc_attr($category_slug); ?>"/>
						</div>
					<?php } ?>
					<input class="input-search s w-full pb-0 border-solid" type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php echo esc_attr__('What Are You Looking For ?', 'botanica'); ?>" autocomplete="off"/>
					<button id="search" class="button-icon btn-search duration-300 absolute w-[70px] h-[52px] text-center md:-right-[2px] right-0 -top-[2px]"
							type="submit">
						<span class="search-icon <?php echo esc_attr(Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_SEARCH_ICON)); ?> text-xl"></span>
					</button>
					<div class="hidden btn-search_clear-text absolute right-5 top-5 cursor-pointer text-[#cdcdcd]"><i class="rbb-icon-close-1"></i></div>
				</div>
				<input type="hidden" name="post_type" value="product"/>
			</form>
	<?php
	echo get_template_part('template-parts/components/search/search-result');
	?>
	</div>
	</div>
</div>
