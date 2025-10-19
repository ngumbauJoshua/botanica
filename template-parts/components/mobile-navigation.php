<?php
/**
 * Mobile Navigation
 *
 * @package RisingBambooTheme.
 */

use RisingBambooCore\Helper\Helper as RisingBambooCoreHelper;
use RisingBambooTheme\App\App;
use RisingBambooTheme\App\Menu\Menu;
use RisingBambooTheme\Helper\Setting;

?>

<div id="rbb-mobile-navigation" class="fixed z-[999] bottom-0 z-50 left-0 bg-[color:var(--rbb-mobile-navigation-bg-color)] [&>*]:!text-[var(--rbb-mobile-navigation-text-color)] w-full md:hidden text-[0.625rem]">
	<div class="grid py-0.5 <?php echo ( RisingBambooCoreHelper::woocommerce_wishlist_activated() ) ? 'grid-cols-4' : 'grid-cols-3'; ?> gap-0 text-center text-[#9b9b9b] shadow-[0_-8px_29px_0_rgba(0,0,0,0.1)] [&>*:not(:last-child)]:border-r [&>*:not(:last-child)]:border-[#eaeaea]">
		<div class="col-span-1 px-0 pt-2 pb-[5px]">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block leading-5 !text-[var(--rbb-mobile-navigation-text-color)] hover:!text-[var(--rbb-menu-link-hover-color)]"><i class="rbb-icon-home-filled-2 text-[1.1rem]"></i></a>
			<span class="block leading-[14px]"><?php echo esc_html__('Home', 'botanica'); ?></span>
		</div>
		<div class="col-span-1 px-0 pt-2 pb-[5px]">
			<a href="<?php echo esc_url(home_url('shop')); ?>/" class="inline-block leading-5 !text-[var(--rbb-mobile-navigation-text-color)] hover:!text-[var(--rbb-menu-link-hover-color)]"><i class="rbb-icon-menu-13 text-[1.1rem]"></i></a>
			<span class="block leading-[14px]"><?php echo esc_html__('Shopping', 'botanica'); ?></span>
		</div>
		<?php if ( RisingBambooCoreHelper::woocommerce_wishlist_activated() ) { ?>
			<div class="col-span-1 relative px-0 pt-2 pb-[5px]">
				<a href="<?php echo esc_url(WPcleverWoosw::get_url()); ?>" class="inline-block leading-5 !text-[var(--rbb-mobile-navigation-text-color)] hover:!text-[var(--rbb-menu-link-hover-color)]">
					<i class="<?php echo esc_attr(Setting::get(RISING_BAMBOO_KIRKI_FIELD_WOOCOMMERCE_WISHLIST_ICON)); ?> text-[1.1rem]"></i></a>
					<?php if ( WPcleverWoosw::get_count() !== '0' ) { ?>
					<span class="wishlist-count bg-[color:var(--rbb-general-primary-color)] absolute top-1 left-1/2 ml-1 text-white text-center rounded-full w-[19px] h-[19px] leading-[17px] text-[10px] border-[1px] border-white">
	                	<?php echo WPcleverWoosw::get_count(); // phpcs:ignore ?>
					</span>
				<?php } ?>
				<span class="block leading-[14px]"><?php echo esc_html__('Wishlist', 'botanica'); ?></span>
			</div>
		<?php } ?>
		<div class="col-span-1 px-0 pt-2 pb-[5px]"
			<?php if ( false === is_user_logged_in() ) { ?>
				onclick="RisingBambooModal.modal('.account-form-popup', event)"
			<?php } else { ?>
				onclick="RisingBambooModal.modal('.rbb-account-canvas', event)"
			<?php } ?> >
			<span class="account leading-5 cursor-pointer !text-[var(--rbb-mobile-navigation-text-color) hover:!text-[var(--rbb-menu-link-hover-color)] inline-block">
				<i class="<?php echo esc_attr(Setting::get(RISING_BAMBOO_KIRKI_FIELD_COMPONENT_ACCOUNT_ICON)); ?> text-[1.1rem]"></i>
			</span>
			<span class="block leading-[14px]"><?php echo esc_html__('Account', 'botanica'); ?></span>
		</div>
	</div>
</div>

<?php if ( is_user_logged_in() ) { ?>
	<div class="rbb-account-canvas rbb-modal">
		<div class="menu-canvas-right text-center md:w-[300px] w-4/5 fixed top-0 right-0 bottom-0 p-5 bg-white z-30">
			<header class="rbb-modal-header">
				<button class="rbb-close-modal" aria-label="close modal" tabindex="0">✕</button>
			</header>
			<div class="rbb-main-navigation">
				<div class="font-bold text-base text-center">
					<div class="rounded-full inline-block overflow-hidden">
						<?php echo get_avatar(get_the_author_meta('user_email'), 55); ?>
					</div>
					<div class="author block mt-4 mb-12">
						<?php echo esc_html__('Welcome ', 'botanica') . wp_kses_post(ucwords(wp_get_current_user()->get('display_name'))); ?>
					</div>
				</div>
				<div class="menu primary-menu relative">
					<?php echo wp_kses_post(Menu::account_menu()); ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
