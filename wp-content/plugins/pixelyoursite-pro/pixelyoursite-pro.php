<?php

/**
 * Plugin Name: PixelYourSite PRO
 * Plugin URI: http://www.pixelyoursite.com/
 * Description: Implement the Meta Pixel with Conversion API, Google Analytics, the Google Ads Tag and the TikTok Tag. Now with full GTM support. Track key actions with automatic events, or create your own events. WooCommerce and EDD fully integrated. Full support for <a href="https://www.pixelyoursite.com/plugins/consentmagic?utm_source=PixelYourSite&utm_medium=Professional&utm_campaign=Description-link" target="_blank">ConsentMagic.</a>.
 * Version: 11.3.0.2
 * Author: PixelYourSite
 * Author URI: http://www.pixelyoursite.com
 * License URI: http://www.pixelyoursite.com/pixel-your-site-pro-license
 *
 * Requires at least: 4.4
 * Tested up to: 6.8
 *
 * WC requires at least: 2.6.0
 * WC tested up to: 9.8
 *
 * Requires PHP: 7.4
 * Requires at least: 7.2.5
 * Text Domain: pys
 */


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

define( 'PYS_VERSION', '11.3.0.2' );
define( 'PYS_PINTEREST_MIN_VERSION', '5.5.3' );
define( 'PYS_SUPER_PACK_MIN_VERSION', '5.4.1' );
define( 'PYS_BING_MIN_VERSION', '3.5.3' );
define( 'PYS_PLUGIN_NAME', 'PixelYourSite Professional' );
define( 'PYS_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'PYS_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
define( 'PYS_PRO_PLUGIN_FILE', __FILE__ );
define( 'PYS_PRO_PLUGIN_BASENAME', plugin_basename( PYS_PRO_PLUGIN_FILE ) );
define( 'PYS_GTM_CONTAINERS_PATH', untrailingslashit( plugin_dir_url( __FILE__ ) ) .'/containers_gtm/' );

//Brands plugins
// woocommerce brands */
define( 'PYS_BRAND_YWBA',    'yith-woocommerce-brands-add-on/init.php');
define( 'PYS_BRAND_PEWB',    'perfect-woocommerce-brands/perfect-woocommerce-brands.php');
define( 'PYS_BRAND_PRWB',    'premmerce-woocommerce-brands/premmerce-brands.php');
define( 'PYS_BRAND_PBFW',    'product-brands-for-woocommerce/product-brands-for-woocommerce.php');
define( 'PYS_BRAND_WB',    'woo-brand/main.php');
define( 'PYS_BRAND_PYS_PCF', 'product-catalog-feed-pro/product-catalog-feed-pro.php');

define('PYS_SHOP_NAME', get_bloginfo('name'));
function isPysFreeActive() {

    if ( ! function_exists( 'is_plugin_active' ) ) {
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    }

    return is_plugin_active( 'pixelyoursite/facebook-pixel-master.php' );

}

register_activation_hook( __FILE__, 'pysProActivation' );
function pysProActivation() {

    if ( isPysFreeActive() ) {
        deactivate_plugins('pixelyoursite/facebook-pixel-master.php');
    }


    \PixelYourSite\manageAdminPermissions();
}



if ( isPysFreeActive() ) {
    return; // exit early when PYS Free is active
}
require_once PYS_PATH.'/vendor/autoload.php';
require_once PYS_PATH.'/includes/functions-common.php';
require_once PYS_PATH.'/includes/logger/class-pys-logger.php';
require_once PYS_PATH.'/includes/db/class-db.php';
require_once PYS_PATH.'/includes/class-event-id-generator.php';
require_once PYS_PATH.'/includes/functions-cartflows.php';
require_once PYS_PATH.'/includes/functions-admin.php';
require_once PYS_PATH.'/includes/events/class-event.php';
require_once PYS_PATH.'/includes/events/interface-events.php';
require_once PYS_PATH.'/includes/events/class-event-single.php';
require_once PYS_PATH.'/includes/events/class-event-grouped.php';
require_once PYS_PATH.'/includes/events/class-events-automatic.php';
require_once PYS_PATH.'/includes/events/class-events-woo.php';
require_once PYS_PATH.'/includes/events/class-events-edd.php';
require_once PYS_PATH.'/includes/events/class-events-fdp.php';
require_once PYS_PATH.'/includes/events/class-events-wcf.php';
require_once PYS_PATH.'/includes/events/class-events-custom.php';
require_once PYS_PATH.'/includes/formEvents/FormSubmissionHandler.php';
require_once PYS_PATH.'/includes/events/PageVisitTracker-helper.php';
require_once PYS_PATH.'/includes/events/EmbeddedVideo.php';

require_once PYS_PATH .'/containers_gtm/container.php';
require_once PYS_PATH.'/includes/functions-custom-event.php';
require_once PYS_PATH.'/includes/functions-woo.php';
require_once PYS_PATH.'/includes/functions-edd.php';
require_once PYS_PATH.'/includes/functions-system-report.php';
require_once PYS_PATH.'/includes/functions-license.php';
require_once PYS_PATH.'/includes/functions-update-plugin.php';
require_once PYS_PATH.'/includes/functions-gdpr.php';
require_once PYS_PATH.'/includes/functions-migrate.php';
require_once PYS_PATH.'/includes/class-pixel.php';
require_once PYS_PATH.'/includes/class-settings.php';
require_once PYS_PATH.'/includes/class-plugin.php';
require_once PYS_PATH.'/includes/offline_events/class-offline-events.php';
require_once PYS_PATH.'/includes/class-pys.php';
require_once PYS_PATH.'/includes/class-events-manager.php';
require_once PYS_PATH.'/includes/class-custom-event.php';
require_once PYS_PATH.'/includes/class-custom-event-factory.php';
require_once PYS_PATH.'/includes/events/CustomEventClasses/class-settings-custom-event.php';
require_once PYS_PATH.'/includes/events/CustomEventClasses/class-trigger-event.php';
require_once PYS_PATH.'/includes/events/CustomEventClasses/class-conditional-event.php';
require_once PYS_PATH.'/modules/tiktok/tiktok.php';
require_once PYS_PATH.'/modules/tiktok/tiktok-server.php';
require_once PYS_PATH.'/modules/facebook/facebook.php';
require_once PYS_PATH.'/modules/facebook/facebook-server.php';
require_once PYS_PATH.'/modules/google_analytics/ga.php';
require_once PYS_PATH.'/modules/google_analytics/server/measurement_protocol_api.php';
require_once PYS_PATH.'/modules/google_ads/google_ads.php';
require_once PYS_PATH.'/modules/google_tags/gatags.php';
require_once PYS_PATH.'/modules/google_gtm/gtm.php';
require_once PYS_PATH.'/modules/head_footer/head_footer.php';
require_once PYS_PATH.'/modules/statistic/class-statistic.php';
require_once PYS_PATH.'/includes/enrich/class_enrich_order.php';
require_once PYS_PATH.'/includes/enrich/class-enrich_user.php';
require_once PYS_PATH.'/includes/class-events-manager-ajax_hook.php';
require_once PYS_PATH.'/includes/class-fixed-notices.php';
require_once PYS_PATH.'/includes/class-consent.php';


require_once PYS_PATH.'/includes/formEvents/interface-formEvents.php';
require_once PYS_PATH.'/includes/formEvents/CF7/class-formEvent-CF7.php';
require_once PYS_PATH.'/includes/formEvents/forminator/class-formEvent-Forminator.php';
require_once PYS_PATH.'/includes/formEvents/WPForms/class-formEvent-WPForms.php';
require_once PYS_PATH.'/includes/formEvents/Formidable/class-formEvent-Formidable.php';
require_once PYS_PATH.'/includes/formEvents/NinjaForm/class-formEvent-NinjaForm.php';
require_once PYS_PATH.'/includes/formEvents/FluentForm/class-formEvent-FluentForm.php';
require_once PYS_PATH.'/includes/formEvents/GravityForm/class-formEvent-GravityForm.php';
require_once PYS_PATH.'/includes/formEvents/WSForm/class-formEvent-WSForm.php';
require_once PYS_PATH.'/includes/formEvents/ElementorForm/ElementorForm.php';
// here we go...
PixelYourSite\PYS();

add_action( 'before_woocommerce_init', function() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );
