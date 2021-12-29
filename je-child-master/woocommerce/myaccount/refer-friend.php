<?php
/**
 * My Account Refer a Friend
 *
 * Shows the first intro screen on the account dashboard.
 *
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div class="bs-row">
    <div class="bs-col-xs-12 col-refer-friend-wrap">
        <h2 class="text-center">Refer A Friend</h2>
        <?php echo do_shortcode('[automatewoo_referrals_page]'); ?>
    </div>
</div>