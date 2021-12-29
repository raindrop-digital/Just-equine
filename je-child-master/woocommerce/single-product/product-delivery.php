<?php
/**
 * Product Delivery
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
    if( have_rows('delivery_information', 'option') ):
        while( have_rows('delivery_information', 'option') ): the_row();
        
            $delivery_content = get_sub_field('delivery_content', 'option');

            ?> 

            <div class="bs-row">
                <div class="bs-col-xs-12">
                <?php echo $delivery_content; ?>
                </div>
            </div>

<?php endwhile; ?>
<?php endif; ?>