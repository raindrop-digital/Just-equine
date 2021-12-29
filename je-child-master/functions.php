<?php
/**
 * Just Equine Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Just Equine Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_JUST_EQUINE_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'just-equine-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_JUST_EQUINE_CHILD_VERSION, 'all' );
    wp_register_style( 'bootstrap-theme-css', get_stylesheet_directory_uri() . '/inc/css/bootstrap-style.css', array() );
    wp_enqueue_style( 'bootstrap-theme-css' );

    // load custom js
    wp_enqueue_script('custom-accordion-js',get_stylesheet_directory_uri().'/inc/js/custom-accordion.js',array('jquery'),'1.0.0',true);
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

// Greate a global Woo Extras Page
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Woo Extras',
		'menu_title'	=> 'Woo Extras',
		'menu_slug' 	=> 'woo-extras',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

}

// Add In The Box Tab
add_filter( 'woocommerce_product_tabs', 'new_delivery_tab' );
function new_delivery_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['delivery'] = array(
		'title' 	=> __( 'Delivery', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'delivery_content'
	);

	return $tabs;

}
function delivery_content() {
    
    wc_get_template( 'woocommerce/single-product/product-delivery.php' );
	
}

// Add revisions support to the Custom Layout.
function astra_add_revision_cl( $defaults ) {
	$defaults[] = 'revisions';
	return $defaults;
}
add_filter( 'astra_advanced_hooks_supports', 'astra_add_revision_cl' );

// Disable Featured image on all post types.
function your_prefix_featured_image() {
 $post_types = array('page');

 // bail early if the current post type if not the one we want to customize.
 if ( ! in_array( get_post_type(), $post_types ) ) {
 return;
 }
 
 // Disable featured image.
 add_filter( 'astra_featured_image_enabled', '__return_false' );
}

add_action( 'wp', 'your_prefix_featured_image' );

// Disable Astra Schema
add_filter( 'astra_schema_enabled', '__return_false' );

// Gutenberg button default padding
add_filter( 'astra_update_button_padding_defaults', '__return_true' );

// Filter to enable Astra 3.7.4 Gutenberg UI improvements
add_filter( 'astra_get_option_improve-gb-editor-ui', '__return_true' );

// Move Category Description
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 100 );

/* Category Page Div Wrappers */
// Results count Wrapper
add_action('woocommerce_before_main_content', 'bread_open_div', 19);
function bread_open_div() {
    echo '
    <div class="cs-section">
    <div class="cs-wrap">
        <div class="bs-row" id="rw-bread">
            <div class="bs-col-xs-12">
    ';
}

add_action('woocommerce_before_main_content', 'bread_close_div', 21);
function bread_close_div() {
    echo '</div></div></div></div>';
}

// Results count Wrapper
add_action('woocommerce_before_shop_loop', 'results_open_div', 7);
function results_open_div() {
    echo '
    <div class="cs-section">
    <div class="cs-wrap">
        <div class="bs-row" id="rw-filters">
            <div class="bs-col-xs-12">
    ';
}

add_action('woocommerce_before_shop_loop', 'results_close_div', 33);
function results_close_div() {
    echo '</div></div></div></div>';
}

// Pagination Wrapper
add_action('woocommerce_after_shop_loop', 'pag_open_div', 1);
function pag_open_div() {
    echo '<div class="bs-row" id="rw-pag">
        <div class="bs-col-xs-12">
    ';
}

add_action('woocommerce_after_shop_loop', 'pag_close_div', 11);
function pag_close_div() {
    echo '</div></div>';
}

// Desc Wrapper
add_action('woocommerce_after_shop_loop', 'cat_open_div', 99);
function cat_open_div() {
    echo '<div class="bs-row" id="rw-cat">
        <div class="bs-col-xs-12">
    ';
}

add_action('woocommerce_after_shop_loop', 'cat_close_div', 101);
function cat_close_div() {
    echo '</div></div>';
}

// change phone number label
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
     $fields['billing']['billing_phone']['label'] = 'Mobile Phone Number';
     return $fields;
}

// remove private prefix
function remove_private_prefix($title) {
  $title = str_replace('Private:', '', $title);
  return $title;
}
add_filter('the_title','remove_private_prefix');

// Payment Title
function payment_title() {
echo ' 
<div class="bs-row">
<div class="bs-col-xs-12">
<h3 id="order_review_heading">Payment</h3>
</div>
</div>';
}
add_filter( 'woocommerce_review_order_before_payment', 'payment_title');

// Hide category product count in product archives
add_filter( 'woocommerce_subcategory_count_html', '__return_false' );

// hide coupon field on checkout page
function hide_coupon_field_on_checkout( $enabled ) {

	if ( is_checkout() ) {
		$enabled = false;
	}

	return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_checkout' );

// Hide What is PayPal
function remove_what_is_paypal( $icon_html, $gateway_id ) {
if( 'paypal' == $gateway_id ) {
   $icon_html = '<img src="/wp-content/plugins/woocommerce/includes/gateways/paypal/assets/images/paypal.png" alt="PayPal Acceptance Mark">';
}
return $icon_html;
}

add_filter( 'woocommerce_gateway_icon', 'remove_what_is_paypal', 10, 2 );

// Remove Description tab title.
add_filter( 'woocommerce_product_description_heading', '__return_null' );

// Hides the product’s weight and dimension in the single product page.
add_filter( 'wc_product_enable_dimensions_display', '__return_false' );

// Change Related products Header.
add_filter('woocommerce_product_related_products_heading',function(){

   return 'You Might Also Like';

});

/**
 * Rename product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_rename_tabs', 98 );
function woo_rename_tabs( $tabs ) {

	$tabs['description']['title'] = __( 'Product Details' );		// Rename the description tab

	return $tabs;

}

// Remove all tabs for gift cards
function removing_product_tabs( $tabs ) {
    // Get the global product object
    global $product;

    // HERE define your specific product Ids
    $targeted_ids = array( 18405 );

    if( $product->is_type( 'variable' ) && in_array( $product->get_id(), $targeted_ids ) ) {
        unset( $tabs['description'] );            // Remove the description tab
        unset( $tabs['reviews'] );                // Remove the reviews tab
        unset( $tabs['additional_information'] ); // Remove the additional info tab 
        unset( $tabs['delivery'] ); // Remove the delivery tab
    }

    return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'removing_product_tabs', 102 );

// Remove related products for gift cards
add_action( 'woocommerce_after_single_product_summary', 'remove_related_products_conditionally', 1 );
function remove_related_products_conditionally(){
    global $product;

    // HERE Define your targeted product Id(s) (in the array)
    $targeted_products = array( 56274  );

    if( in_array( $product->get_id(), $targeted_products ) )
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
}


// Remove Cross Sells From Default Position 
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

// Add them back UNDER the Cart Table
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );

// Email Banner
add_action( 'woocommerce_email_header', 'email_header' , 50, 4);
function email_header( $email_heading, $email ) {    
        echo '<div style="text-align:center; margin-bottom:16px;">
            <img src="'.home_url( "/wp-content/themes/je-child-master/inc/images/email-hero-banner.jpg" ).'" alt="myPic"/>
        </div>';
}

// Remove gift card from checkout
function remove_gc_actions() {
	remove_action( 'woocommerce_review_order_before_submit', array( WC_GC()->cart, 'display_form' ), 20 );
}
add_action( 'init', 'remove_gc_actions' );

// Remove Cart gift card position
remove_action( 'woocommerce_proceed_to_checkout', array( WC_GC()->cart, 'display_form' ), 9 );

// Add them back UNDER the Cart Table
add_action( 'woocommerce_after_cart_table', array( WC_GC()->cart, 'display_form' ), 9 );

/**
 * Hide shipping rates when free shipping is available.
 * Updated to support WooCommerce 2.6 Shipping Zones.
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			break;
		}
	}
	return ! empty( $free ) ? $free : $rates;
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );

/* Add Google Tag Manager javascript code as close to 
the opening <head> tag as possible
=====================================================*/
function add_gtm_head(){
?>
 
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-N956ZTR');</script>
<!-- End Google Tag Manager -->
 
<?php 
}
add_action( 'wp_head', 'add_gtm_head', 6 );

/* Add Google Tag Manager noscript codeimmediately after 
the opening <body> tag
========================================================*/
function add_gtm_body(){
?>
 
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N956ZTR"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
 
<?php 
}
add_action( 'wp_body_open', 'add_gtm_body' );

/* Add fb to head
=====================================================*/
function add_fb_head(){ ?>

    <meta name="facebook-domain-verification" content="k3cwabpyn9wuykxe7pdycrnakceyzj" />
    
    <?php 
    }
    add_action( 'wp_head', 'add_fb_head', 5 );

// Send Export to FTP Server
function wpae_after_export( $export_id ) {

    // Retrieve export object.
    $export = new PMXE_Export_Record();
    $export->getById($export_id);
    
    // Check if "Secure Mode" is enabled in All Export > Settings.
    $is_secure_export = PMXE_Plugin::getInstance()->getOption('secure');

    // Retrieve file path when not using secure mode.
    if ( !$is_secure_export) {
        $filepath = get_attached_file($export->attch_id);

    // Retrieve file path when using secure mode.                    
    } else {
        $filepath = wp_all_export_get_absolute_path($export->options['filepath']);
    }

    // Path to the export file.
    $localfile = $filepath;

    // File name of remote file (destination file name).
    $remotefile = basename($filepath);
    
    // Remote FTP server details.
    // The 'path' is relative to the FTP user's login directory.
    $ftp = array(
        'server' => 'marketplace-ftp.kentucky-horsewear.com',
        'user' => 'just.equine@marketplace-ftp.kentucky-horsewear.com',
        'pass' => 'fX5xC(o{I1#(',
        'path' => ''
    );

    // Ensure username is formatted properly
    $ftp['user'] = str_replace('@', '%40', $ftp['user']);
    
    // Ensure password is formatted properly
    $ftp['pass'] = str_replace(array('#','?','/','\\'), array('%23','%3F','%2F','%5C'), $ftp['pass']);
    
    // Remote FTP URL.
    $remoteurl = "ftp://{$ftp['user']}:{$ftp['pass']}@{$ftp['server']}{$ftp['path']}/{$remotefile}";

    // Retrieve cURL object.
    $ch = curl_init();

    // Open export file.
    $fp = fopen($localfile, "rb");
    
    // Proceed if the local file was opened.
    if ($fp) {
        
        // Provide cURL the FTP URL.
        curl_setopt($ch, CURLOPT_URL, $remoteurl);

        // Prepare cURL for uploading files.
        curl_setopt($ch, CURLOPT_UPLOAD, 1);

        // Provide the export file to cURL.
        curl_setopt($ch, CURLOPT_INFILE, $fp);

        // Provide the file size to cURL.
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localfile));
        
        // Start the file upload.
        curl_exec($ch);

        // If there is an error, write error number & message to PHP's error log.
        if($errno = curl_errno($ch)) {
            if (version_compare(phpversion(), '5.5.0', '>=')) {
                
                // If PHP 5.5.0 or greater is used, use newer function for cURL error message.
                $error_message = curl_strerror($errno);

            } else {

                // Otherwise, use legacy cURL error message function.
                $error_message = curl_error($ch);
            }

            // Write error to PHP log.
            error_log("cURL error ({$errno}): {$error_message}");

        }
        
        // Close the connection to remote server.
        curl_close($ch);
        
    } else {

        // If export file could not be found, write to error log.
        error_log("Could not find export file");

    }
}

add_action('pmxe_after_export', 'wpae_after_export', 10, 1);


// SETTINGS: The countries codes (2 capital letters) in the array
function defined_eu_countries(){
    return array('AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IM', 'IT', 'LT', 'LU', 'LV', 'MT', 'MC', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK');
}

// Add dynamic message to checkout.
add_action( 'woocommerce_checkout_after_terms_and_conditions', 'add_terms_and_policy', 20 );
function add_terms_and_policy() {

    // HERE set the countries codes (2 capital letters) in this array:
    $countries = defined_eu_countries();

    // Get customer billing or shipping country
    $country = WC()->customer->get_shipping_country();
    $country = empty($country) ? WC()->customer->get_billing_country() : $country;
    
    if (in_array($country, $countries)) {
        
        echo '<p>By placing this order you accept our <a href="/terms-and-conditions/">Terms and Conditions</a> and will pay any customs & duty charges incurred by importing products from overseas. If you fail to pay the charges, You understand that any return costs will be deducted from your original payment.</p>';
        
    } else {

        echo '<p>By placing this order, you agree to our <a href="/terms-and-conditions/">Terms and Conditions.</a></p>';
    }
}

// Set a minimum order amount for checkout.
add_action( 'woocommerce_check_cart_items', 'required_min_cart_subtotal_amount' );
function required_min_cart_subtotal_amount() {

    if( is_cart() || is_checkout() ) {
        global $woocommerce;
        
        // HERE set the countries codes (2 capital letters) in this array:
        $eucountries = array('AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IM', 'IT', 'LT', 'LU', 'LV', 'MT', 'MC', 'NL', 'PL', 'PT', 'RO', 'SE', 'SI', 'SK');
        
        // Get customer billing or shipping country
        $country = WC()->customer->get_shipping_country();
        $country = empty($country) ? WC()->customer->get_billing_country() : $country;

        // HERE Set minimum cart total amount
        $minimum_amount = 150;
        
        // Total (before taxes and shipping charges)
        $cart_subtotal = WC()->cart->subtotal;
        
        // Add an error notice is cart total is less than the minimum required
        if( $cart_subtotal < $minimum_amount && in_array($country, $eucountries)) {
            // Display an error message
            wc_add_notice( sprintf('Your current order subtotal is £%s — you must have an order with a minimum of £%s to place your order.', $cart_subtotal, $minimum_amount), 'error' );
        } 
    }
}

// Make footer sticky
add_action( 'wp_footer', 'astra_footer_align_bottom' );
function astra_footer_align_bottom () {
	?>
	<script type="text/javascript">
		document.addEventListener(
			"DOMContentLoaded",
			function() {
				fullHeight();
			},
			false
			);
		function fullHeight() {
			var headerHeight = document.querySelector("header").clientHeight;
			var footerHeight = document.querySelector("footer").clientHeight;
			var headerFooter = headerHeight + footerHeight;
			var content = document.querySelector("#content");
			content.style.minHeight = "calc( 100vh - " + headerFooter + "px )";
		}
	</script>
	<?php
}

// Image sizes on woocomerce category
function set_max_srcset_width( $max_width ) {
    if ( class_exists( 'WooCommerce' ) && ( is_product_category() || is_shop() ) ) {
        $max_width = 160;
    } else {
        $max_width = 260;
    }
    return $max_width;
}
add_filter( 'max_srcset_image_width', 'set_max_srcset_width' );


// My Account Referral pages

//Setup End Point for Refer Friend
add_action('init', function() {
	add_rewrite_endpoint('refer-friend', EP_ROOT | EP_PAGES);
});

// add my account menu item for refer friend
add_filter('woocommerce_account_menu_items', function($items) {
	$logout = $items['customer-logout'];
	unset($items['customer-logout']);
	$items['refer-friend'] = __('Refer A Friend', 'txtdomain');
	$items['customer-logout'] = $logout;
	return $items;
});

// Hook in content of refer friend page
function add_refer_friend_module(){
	
	wc_get_template('myaccount/refer-friend.php'); 
}
add_action('woocommerce_account_refer-friend_endpoint','add_refer_friend_module', 1);


/* Auto Apply Coupon */
add_action('woocommerce_before_cart', 'auto_apply_discount_coupon');
function auto_apply_discount_coupon() {
    $wc_coupon = new WC_Coupon('doublepoints'); // get intance of wc_coupon code
    if (!$wc_coupon || !$wc_coupon->is_valid()) {
        return;
    }

    $coupon_code = $wc_coupon->get_code();
    if (!$coupon_code) {
        return;
    }

    global $woocommerce;
    if (!$woocommerce->cart->has_discount($coupon_code)) {
        // You can call apply_coupon() without checking if the coupon already has been applied,
        // because the function apply_coupon() will itself make sure to not re-add it if it was applied before.
        // However this if-check prevents the customer getting a error message saying
        // “The coupon has already been applied” every time the cart is updated.
        if (!$woocommerce->cart->apply_coupon($coupon_code)) {
            $woocommerce->wc_print_notices();
            return;
        }

        wc_print_notice('<div class="woocommerce_message"><strong>Your double points has been appliced successfully.</strong></div>', 'notice');
    }
} 

// Hide fields in shipping calculator
add_filter( 'woocommerce_shipping_calculator_enable_city', '__return_false' );
add_filter( 'woocommerce_shipping_calculator_enable_state', '__return_false' );
add_filter( 'woocommerce_shipping_calculator_enable_postcode', '__return_true' );

// default checkout state
add_filter( 'default_checkout_billing_state', 'change_default_checkout_state' );
add_filter( 'default_checkout_shipping_state', 'change_default_checkout_state' );
function change_default_checkout_state() {
    return ''; //set state code if you want to set it otherwise leave it blank.
}