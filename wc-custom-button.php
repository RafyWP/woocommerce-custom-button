<?php
/**
 * Plugin Name: WC Custom Button
 * Plugin URI: https://litcode.store/
 * Description: Allows setting a custom label for the "Add to Cart" button on each product page.
 * Version: 1.0.0
 * Author: Rafy
 * Author URI: https://litcode.store/
 * Text Domain: wc-custom-button
 * Domain Path: /languages
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add a custom field to the product edit page for the "Add to Cart" button label.
 *
 * @since 1.0.0
 * @return void
 */
function wc_custom_button_add_field() {
	woocommerce_wp_text_input( array(
		'id'          => '_wc_custom_button_label',
		'label'       => __( 'Custom Add to Cart Label', 'wc-custom-button' ),
		'desc_tip'    => true,
		'description' => __( 'Enter a custom label for the "Add to Cart" button.', 'wc-custom-button' ),
	) );
}
add_action( 'woocommerce_product_options_general_product_data', 'wc_custom_button_add_field' );

/**
 * Save the custom field value.
 *
 * @since 1.0.0
 * @param int $post_id The product ID.
 * @return void
 */
function wc_custom_button_save_field( $post_id ) {
	$custom_label = isset( $_POST['_wc_custom_button_label'] ) ? sanitize_text_field( $_POST['_wc_custom_button_label'] ) : '';
	update_post_meta( $post_id, '_wc_custom_button_label', $custom_label );
}
add_action( 'woocommerce_process_product_meta', 'wc_custom_button_save_field' );

/**
 * Modify the "Add to Cart" button text on the single product page.
 *
 * @since 1.0.0
 * @param string     $text    The default button text.
 * @param WC_Product $product The product object.
 * @return string The modified button text.
 */
function wc_custom_button_add_to_cart_text( $text, $product ) {
	$custom_label = get_post_meta( $product->get_id(), '_wc_custom_button_label', true );
	return ! empty( $custom_label ) ? $custom_label : $text;
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'wc_custom_button_add_to_cart_text', 10, 2 );
