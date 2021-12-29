<?php
/**
 * Product Content Features
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php 
    if( have_rows('product_content') ):
        while( have_rows('product_content') ): the_row(); 
        
            $feature_image = get_sub_field('main_feature_image');
            $feature_content = get_sub_field('main_feature_content');

            ?>
               <?php 
                    if( get_row_index() % 2 == 0 ) { ?>
                    <div class="container-product py-2" id="product-content-box">
                        <div class="container-product-inner p-2">
                            <div class="bs-row">
                                <div class="bs-col-xs-12 bs-col-md-6 col-product-image">
                                    <img src="<?php echo esc_url( $feature_image['url'] ); ?>" alt="<?php echo esc_attr( $feature_image['alt'] ); ?>" /></div>
                                <div class="bs-col-xs-12 bs-col-md-6 bs-flex bs-flex-direction-col bs-justify-content-center col-product-content">
                                    <p><?php echo $feature_content; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

<?php } else { ?>

<div class="container-product py-2" id="product-content-box">
    <div class="container-product-inner p-2">
        <div class="bs-row row-reverse">
            <div class="bs-col-xs-12 bs-col-md-6 bs-flex bs-flex-direction-col bs-justify-content-center col-product-content">
                <p><?php echo $feature_content; ?></p>
            </div>
            <div class="bs-col-xs-12 bs-col-md-6 col-product-image">
                <img src="<?php echo esc_url( $feature_image['url'] ); ?>" alt="<?php echo esc_attr( $feature_image['alt'] ); ?>" />
            </div>
        </div>
    </div>
</div>
<?php 
}

endwhile; //End the loop
                                  
 else :

endif; ?>