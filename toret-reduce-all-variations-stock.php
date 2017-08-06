<?php
/**
 * @package   Toret Product Variation Table
 * @author    Vladislav Musílek
 * @license   GPL-2.0+
 * @link      http://toret.cz
 * @copyright 2017 Toret.cz
 *
 * Plugin Name:       Toret Reduce All Variations Stock
 * Plugin URI:        
 * Description:       Plugin change stock quantity for all variations, when one is sell
 * Version:           1.0
 * Author:            Vladislav Musílek
 * Author URI:        toret.cz
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


add_action( 'woocommerce_variation_set_stock', 'toret_reduce_all_variations', 10, 1 );

/**
 * Change stock
 *
 * @since    1.0
 */
function toret_reduce_all_variations( $product ){

	$qty = $product->get_stock_quantity();

	$parent = wp_get_post_parent_id( $product->get_id() );
	$parent_product = wc_get_product( $parent );
		
	$variations = $parent_product->get_available_variations();

	foreach( $variations as $variation ){

		//Must set directly to custom field, $product->set_stock_quantity() call this loop again for each variation and stock is set by last variation qty
		$variation_product = update_post_meta( $variation['variation_id'], '_stock', $qty );

	}

}

