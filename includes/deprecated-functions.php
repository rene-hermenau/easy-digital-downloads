<?php
/**
 * Deprecated Functions
 *
 * All functions that have been deprecated.
 *
 * @package     EDD
 * @subpackage  Deprecated
 * @copyright   Copyright (c) 2015, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Get Download Sales Log
 *
 * Returns an array of sales and sale info for a download.
 *
 * @since       1.0
 * @deprecated  1.3.4
 *
 * @param int $download_id ID number of the download to retrieve a log for
 * @param bool $paginate Whether to paginate the results or not
 * @param int $number Number of results to return
 * @param int $offset Number of items to skip
 *
 * @return mixed array|bool
*/
function edd_get_download_sales_log( $download_id, $paginate = false, $number = 10, $offset = 0 ) {
	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.3.4', null, $backtrace );

	$sales_log = get_post_meta( $download_id, '_edd_sales_log', true );

	if ( $sales_log ) {
		$sales_log = array_reverse( $sales_log );
		$log = array();
		$log['number'] = count( $sales_log );
		$log['sales'] = $sales_log;

		if ( $paginate ) {
			$log['sales'] = array_slice( $sales_log, $offset, $number );
		}

		return $log;
	}

	return false;
}

/**
 * Get File Download Log
 *
 * Returns an array of file download dates and user info.
 *
 * @deprecated 1.3.4
 * @since 1.0
 *
 * @param int $download_id the ID number of the download to retrieve a log for
 * @param bool $paginate whether to paginate the results or not
 * @param int $number the number of results to return
 * @param int $offset the number of items to skip
 *
 * @return mixed array|bool
*/
function edd_get_file_download_log( $download_id, $paginate = false, $number = 10, $offset = 0 ) {
	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.3.4', null, $backtrace );

	$download_log = get_post_meta( $download_id, '_edd_file_download_log', true );

	if ( $download_log ) {
		$download_log = array_reverse( $download_log );
		$log = array();
		$log['number'] = count( $download_log );
		$log['downloads'] = $download_log;

		if ( $paginate ) {
			$log['downloads'] = array_slice( $download_log, $offset, $number );
		}

		return $log;
	}

	return false;
}

/**
 * Get Downloads Of Purchase
 *
 * Retrieves an array of all files purchased.
 *
 * @since 1.0
 * @deprecated 1.4
 *
 * @param int  $payment_id ID number of the purchase
 * @param null $payment_meta
 * @return bool|mixed
 */
function edd_get_downloads_of_purchase( $payment_id, $payment_meta = null ) {
	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.4', 'edd_get_payment_meta_downloads', $backtrace );

	if ( is_null( $payment_meta ) ) {
		$payment_meta = edd_get_payment_meta( $payment_id );
	}

	$downloads = maybe_unserialize( $payment_meta['downloads'] );

	if ( $downloads )
		return $downloads;

	return false;
}

/**
 * Get Menu Access Level
 *
 * Returns the access level required to access the downloads menu. Currently not
 * changeable, but here for a future update.
 *
 * @since 1.0
 * @deprecated 1.4.4
 * @return string
*/
function edd_get_menu_access_level() {
	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.4.4', 'current_user_can(\'manage_shop_settings\')', $backtrace );

	return apply_filters( 'edd_menu_access_level', 'manage_options' );
}



/**
 * Check if only local taxes are enabled meaning users must opt in by using the
 * option set from the EDD Settings.
 *
 * @since 1.3.3
 * @deprecated 1.6
 * @global $edd_options
 * @return bool $local_only
 */
function edd_local_taxes_only() {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.6', 'no alternatives', $backtrace );

	global $edd_options;

	$local_only = isset( $edd_options['tax_condition'] ) && $edd_options['tax_condition'] == 'local';

	return apply_filters( 'edd_local_taxes_only', $local_only );
}

/**
 * Checks if a customer has opted into local taxes
 *
 * @since 1.4.1
 * @deprecated 1.6
 * @uses EDD_Session::get()
 * @return bool
 */
function edd_local_tax_opted_in() {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.6', 'no alternatives', $backtrace );

	$opted_in = EDD()->session->get( 'edd_local_tax_opt_in' );
	return ! empty( $opted_in );
}

/**
 * Show taxes on individual prices?
 *
 * @since 1.4
 * @deprecated 1.9
 * @global $edd_options
 * @return bool Whether or not to show taxes on prices
 */
function edd_taxes_on_prices() {
	global $edd_options;

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.9', 'no alternatives', $backtrace );

	return apply_filters( 'edd_taxes_on_prices', isset( $edd_options['taxes_on_prices'] ) );
}

/**
 * Show Has Purchased Item Message
 *
 * Prints a notice when user has already purchased the item.
 *
 * @since 1.0
 * @deprecated 1.8
 * @global $user_ID
 */
function edd_show_has_purchased_item_message() {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.8', 'no alternatives', $backtrace );

	global $user_ID, $post;

	if( !isset( $post->ID ) )
		return;

	if ( edd_has_user_purchased( $user_ID, $post->ID ) ) {
		$alert = '<p class="edd_has_purchased">' . __( 'You have already purchased this item, but you may purchase it again.', 'easy-digital-downloads' ) . '</p>';
		echo apply_filters( 'edd_show_has_purchased_item_message', $alert );
	}
}

/**
 * Flushes the total earning cache when a new payment is created
 *
 * @since 1.2
 * @deprecated 1.8.4
 * @param int $payment Payment ID
 * @param array $payment_data Payment Data
 * @return void
 */
function edd_clear_earnings_cache( $payment, $payment_data ) {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.8.4', 'no alternatives', $backtrace );

	delete_transient( 'edd_total_earnings' );
}
//add_action( 'edd_insert_payment', 'edd_clear_earnings_cache', 10, 2 );

/**
 * Get Cart Amount
 *
 * @since 1.0
 * @deprecated 1.9
 * @param bool $add_taxes Whether to apply taxes (if enabled) (default: true)
 * @param bool $local_override Force the local opt-in param - used for when not reading $_POST (default: false)
 * @return float Total amount
*/
function edd_get_cart_amount( $add_taxes = true, $local_override = false ) {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '1.9', 'edd_get_cart_subtotal() or edd_get_cart_total()', $backtrace );

	$amount = edd_get_cart_subtotal( );
	if ( ! empty( $_POST['edd-discount'] ) || edd_get_cart_discounts() !== false ) {
		// Retrieve the discount stored in cookies
		$discounts = edd_get_cart_discounts();

		// Check for a posted discount
		$posted_discount = isset( $_POST['edd-discount'] ) ? trim( $_POST['edd-discount'] ) : '';

		if ( $posted_discount && ! in_array( $posted_discount, $discounts ) ) {
			// This discount hasn't been applied, so apply it
			$amount = edd_get_discounted_amount( $posted_discount, $amount );
		}

		if( ! empty( $discounts ) ) {
			// Apply the discounted amount from discounts already applied
			$amount -= edd_get_cart_discounted_amount();
		}
	}

	if ( edd_use_taxes() && edd_is_cart_taxed() && $add_taxes ) {
		$tax = edd_get_cart_tax();
		$amount += $tax;
	}

	if( $amount < 0 )
		$amount = 0.00;

	return apply_filters( 'edd_get_cart_amount', $amount, $add_taxes, $local_override );
}

/**
 * Get Purchase Receipt Template Tags
 *
 * Displays all available template tags for the purchase receipt.
 *
 * @since 1.6
 * @deprecated 1.9
 * @author Daniel J Griffiths
 * @return string $tags
 */
function edd_get_purchase_receipt_template_tags() {
	$tags = __('Enter the email that is sent to users after completing a successful purchase. HTML is accepted. Available template tags:','easy-digital-downloads' ) . '<br/>' .
			'{download_list} - ' . __('A list of download links for each download purchased','easy-digital-downloads' ) . '<br/>' .
			'{file_urls} - ' . __('A plain-text list of download URLs for each download purchased','easy-digital-downloads' ) . '<br/>' .
			'{name} - ' . __('The buyer\'s first name','easy-digital-downloads' ) . '<br/>' .
			'{fullname} - ' . __('The buyer\'s full name, first and last','easy-digital-downloads' ) . '<br/>' .
			'{username} - ' . __('The buyer\'s user name on the site, if they registered an account','easy-digital-downloads' ) . '<br/>' .
			'{user_email} - ' . __('The buyer\'s email address','easy-digital-downloads' ) . '<br/>' .
			'{billing_address} - ' . __('The buyer\'s billing address','easy-digital-downloads' ) . '<br/>' .
			'{date} - ' . __('The date of the purchase','easy-digital-downloads' ) . '<br/>' .
			'{subtotal} - ' . __('The price of the purchase before taxes','easy-digital-downloads' ) . '<br/>' .
			'{tax} - ' . __('The taxed amount of the purchase','easy-digital-downloads' ) . '<br/>' .
			'{price} - ' . __('The total price of the purchase','easy-digital-downloads' ) . '<br/>' .
			'{payment_id} - ' . __('The unique ID number for this purchase','easy-digital-downloads' ) . '<br/>' .
			'{receipt_id} - ' . __('The unique ID number for this purchase receipt','easy-digital-downloads' ) . '<br/>' .
			'{payment_method} - ' . __('The method of payment used for this purchase','easy-digital-downloads' ) . '<br/>' .
			'{sitename} - ' . __('Your site name','easy-digital-downloads' ) . '<br/>' .
			'{receipt_link} - ' . __( 'Adds a link so users can view their receipt directly on your website if they are unable to view it in the browser correctly.', 'easy-digital-downloads' );

	return apply_filters( 'edd_purchase_receipt_template_tags_description', $tags );
}


/**
 * Get Sale Notification Template Tags
 *
 * Displays all available template tags for the sale notification email
 *
 * @since 1.7
 * @deprecated 1.9
 * @author Daniel J Griffiths
 * @return string $tags
 */
function edd_get_sale_notification_template_tags() {
	$tags = __( 'Enter the email that is sent to sale notification emails after completion of a purchase. HTML is accepted. Available template tags:', 'easy-digital-downloads' ) . '<br/>' .
			'{download_list} - ' . __('A list of download links for each download purchased','easy-digital-downloads' ) . '<br/>' .
			'{file_urls} - ' . __('A plain-text list of download URLs for each download purchased','easy-digital-downloads' ) . '<br/>' .
			'{name} - ' . __('The buyer\'s first name','easy-digital-downloads' ) . '<br/>' .
			'{fullname} - ' . __('The buyer\'s full name, first and last','easy-digital-downloads' ) . '<br/>' .
			'{username} - ' . __('The buyer\'s user name on the site, if they registered an account','easy-digital-downloads' ) . '<br/>' .
			'{user_email} - ' . __('The buyer\'s email address','easy-digital-downloads' ) . '<br/>' .
			'{billing_address} - ' . __('The buyer\'s billing address','easy-digital-downloads' ) . '<br/>' .
			'{date} - ' . __('The date of the purchase','easy-digital-downloads' ) . '<br/>' .
			'{subtotal} - ' . __('The price of the purchase before taxes','easy-digital-downloads' ) . '<br/>' .
			'{tax} - ' . __('The taxed amount of the purchase','easy-digital-downloads' ) . '<br/>' .
			'{price} - ' . __('The total price of the purchase','easy-digital-downloads' ) . '<br/>' .
			'{payment_id} - ' . __('The unique ID number for this purchase','easy-digital-downloads' ) . '<br/>' .
			'{receipt_id} - ' . __('The unique ID number for this purchase receipt','easy-digital-downloads' ) . '<br/>' .
			'{payment_method} - ' . __('The method of payment used for this purchase','easy-digital-downloads' ) . '<br/>' .
			'{sitename} - ' . __('Your site name','easy-digital-downloads' );

	return apply_filters( 'edd_sale_notification_template_tags_description', $tags );
}

/**
 * Email Template Header
 *
 * @access private
 * @since 1.0.8.2
 * @deprecated 2.0
 * @return string Email template header
 */
function edd_get_email_body_header() {
	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '2.0', '', $backtrace );

	ob_start();
	?>
	<html>
	<head>
		<style type="text/css">#outlook a { padding: 0; }</style>
	</head>
	<body dir="<?php echo is_rtl() ? 'rtl' : 'ltr'; ?>">
	<?php
	do_action( 'edd_email_body_header' );
	return ob_get_clean();
}

/**
 * Email Template Footer
 *
 * @since 1.0.8.2
 * @deprecated 2.0
 * @return string Email template footer
 */
function edd_get_email_body_footer() {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '2.0', '', $backtrace );

	ob_start();
	do_action( 'edd_email_body_footer' );
	?>
	</body>
	</html>
	<?php
	return ob_get_clean();
}

/**
 * Applies the Chosen Email Template
 *
 * @since 1.0.8.2
 * @deprecated 2.0
 * @param string $body The contents of the receipt email
 * @param int $payment_id The ID of the payment we are sending a receipt for
 * @param array $payment_data An array of meta information for the payment
 * @return string $email Formatted email with the template applied
 */
function edd_apply_email_template( $body, $payment_id, $payment_data=array() ) {
	global $edd_options;

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '2.0', '', $backtrace );

	$template_name = isset( $edd_options['email_template'] ) ? $edd_options['email_template'] : 'default';
	$template_name = apply_filters( 'edd_email_template', $template_name, $payment_id );

	if ( $template_name == 'none' ) {
		if ( is_admin() )
			$body = edd_email_preview_template_tags( $body );

		return $body; // Return the plain email with no template
	}

	ob_start();

	do_action( 'edd_email_template_' . $template_name );

	$template = ob_get_clean();

	if ( is_admin() )
		$body = edd_email_preview_template_tags( $body );

	$body = apply_filters( 'edd_purchase_receipt_' . $template_name, $body );

	$email = str_replace( '{email}', $body, $template );

	return $email;

}

/**
 * Checks if the user has enabled the option to calculate taxes after discounts
 * have been entered
 *
 * @since 1.4.1
 * @deprecated 2.1
 * @global $edd_options
 * @return bool Whether or not taxes are calculated after discount
 */
function edd_taxes_after_discounts() {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '2.1', 'none', $backtrace );

	global $edd_options;
	$ret = isset( $edd_options['taxes_after_discounts'] ) && edd_use_taxes();
	return apply_filters( 'edd_taxes_after_discounts', $ret );
}

/**
 * Verifies a download purchase using a purchase key and email.
 *
 * @deprecated Please avoid usage of this function in favor of the tokenized urls with edd_validate_url_token()
 * introduced in EDD 2.3
 *
 * @since 1.0
 *
 * @param int    $download_id
 * @param string $key
 * @param string $email
 * @param string $expire
 * @param int    $file_key
 *
 * @return bool True if payment and link was verified, false otherwise
 */
function edd_verify_download_link( $download_id = 0, $key = '', $email = '', $expire = '', $file_key = 0 ) {

	$meta_query = array(
		'relation'  => 'AND',
		array(
			'key'   => '_edd_payment_purchase_key',
			'value' => $key
		),
		array(
			'key'   => '_edd_payment_user_email',
			'value' => $email
		)
	);

	$accepted_stati = apply_filters( 'edd_allowed_download_stati', array( 'publish', 'complete' ) );

	$payments = get_posts( array( 'meta_query' => $meta_query, 'post_type' => 'edd_payment', 'post_status' => $accepted_stati ) );

	if ( $payments ) {
		foreach ( $payments as $payment ) {

			$cart_details = edd_get_payment_meta_cart_details( $payment->ID, true );

			if ( ! empty( $cart_details ) ) {
				foreach ( $cart_details as $cart_key => $cart_item ) {

					if ( $cart_item['id'] != $download_id )
						continue;

					$price_options 	= isset( $cart_item['item_number']['options'] ) ? $cart_item['item_number']['options'] : false;
					$price_id 		= isset( $price_options['price_id'] ) ? $price_options['price_id'] : false;

					$file_condition = edd_get_file_price_condition( $cart_item['id'], $file_key );

					// Check to see if the file download limit has been reached
					if ( edd_is_file_at_download_limit( $cart_item['id'], $payment->ID, $file_key, $price_id ) )
						wp_die( apply_filters( 'edd_download_limit_reached_text', __( 'Sorry but you have hit your download limit for this file.', 'easy-digital-downloads' ) ), __( 'Error', 'easy-digital-downloads' ), array( 'response' => 403 ) );

					// If this download has variable prices, we have to confirm that this file was included in their purchase
					if ( ! empty( $price_options ) && $file_condition != 'all' && edd_has_variable_prices( $cart_item['id'] ) ) {
						if ( $file_condition == $price_options['price_id'] )
							return $payment->ID;
					}

					// Make sure the link hasn't expired

					if ( base64_encode( base64_decode( $expire, true ) ) === $expire ) {
						$expire = base64_decode( $expire ); // If it is a base64 string, decode it. Old expiration dates were in base64
					}

					if ( current_time( 'timestamp' ) > $expire ) {
						wp_die( apply_filters( 'edd_download_link_expired_text', __( 'Sorry but your download link has expired.', 'easy-digital-downloads' ) ), __( 'Error', 'easy-digital-downloads' ), array( 'response' => 403 ) );
					}
					return $payment->ID; // Payment has been verified and link is still valid
				}

			}

		}

	} else {
		wp_die( __( 'No payments matching your request were found.', 'easy-digital-downloads' ), __( 'Error', 'easy-digital-downloads' ), array( 'response' => 403 ) );
	}
	// Payment not verified
	return false;
}

/**
 * Get Success Page URL
 *
 * @param string $query_string
 * @since       1.0
 * @deprecated  2.6 Please avoid usage of this function in favor of edd_get_success_page_uri()
 * @return      string
*/
function edd_get_success_page_url( $query_string = null ) {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '2.6', 'edd_get_success_page_uri()', $backtrace );

	return apply_filters( 'edd_success_page_url', edd_get_success_page_uri( $query_string ) );
}

/**
 * Reduces earnings and sales stats when a purchase is refunded
 *
 * @since 1.8.2
 * @param int $payment_id the ID number of the payment
 * @param string $new_status the status of the payment, probably "publish"
 * @param string $old_status the status of the payment prior to being marked as "complete", probably "pending"
 * @deprecated  2.5.7 Please avoid usage of this function in favor of refund() in EDD_Payment
 * @internal param Arguments $data passed
 */
function edd_undo_purchase_on_refund( $payment_id, $new_status, $old_status ) {

	$backtrace = debug_backtrace();
	_edd_deprecated_function( 'edd_undo_purchase_on_refund', '2.5.7', 'EDD_Payment->refund()', $backtrace );

	$payment = new EDD_Payment( $payment_id );
	$payment->refund();
}

/**
 * Get Earnings By Date
 *
 * @since 1.0
 * @deprecated 2.7
 * @param int $day Day number
 * @param int $month_num Month number
 * @param int $year Year
 * @param int $hour Hour
 * @return int $earnings Earnings
 */
function edd_get_earnings_by_date( $day = null, $month_num = null, $year = null, $hour = null, $include_taxes = true ) {
	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '2.7', 'EDD_Payment_Stats()->get_earnings()', $backtrace );

	global $wpdb;

	$args = array(
		'post_type'      => 'edd_payment',
		'nopaging'       => true,
		'year'           => $year,
		'monthnum'       => $month_num,
		'post_status'    => array( 'publish', 'revoked' ),
		'fields'         => 'ids',
		'update_post_term_cache' => false,
		'include_taxes'  => $include_taxes,
	);

	if ( ! empty( $day ) ) {
		$args['day'] = $day;
	}

	if ( ! empty( $hour ) || $hour == 0 ) {
		$args['hour'] = $hour;
	}

	$args   = apply_filters( 'edd_get_earnings_by_date_args', $args );
	$cached = get_transient( 'edd_stats_earnings' );
	$key    = md5( json_encode( $args ) );

	if ( ! isset( $cached[ $key ] ) ) {
		$sales = get_posts( $args );
		$earnings = 0;
		if ( $sales ) {
			$sales = implode( ',', $sales );

			$total_earnings = $wpdb->get_var( "SELECT SUM(meta_value) FROM $wpdb->postmeta WHERE meta_key = '_edd_payment_total' AND post_id IN ({$sales})" );
			$total_tax      = 0;

			if ( ! $include_taxes ) {
				$total_tax = $wpdb->get_var( "SELECT SUM(meta_value) FROM $wpdb->postmeta WHERE meta_key = '_edd_payment_tax' AND post_id IN ({$sales})" );
			}

			$earnings += ( $total_earnings - $total_tax );
		}
		// Cache the results for one hour
		$cached[ $key ] = $earnings;
		set_transient( 'edd_stats_earnings', $cached, HOUR_IN_SECONDS );
	}

	$result = $cached[ $key ];

	return round( $result, 2 );
}

/**
 * Get Sales By Date
 *
 * @since 1.1.4.0
 * @deprecated 2.7
 * @author Sunny Ratilal
 * @param int $day Day number
 * @param int $month_num Month number
 * @param int $year Year
 * @param int $hour Hour
 * @return int $count Sales
 */
function edd_get_sales_by_date( $day = null, $month_num = null, $year = null, $hour = null ) {
	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '2.7', 'EDD_Payment_Stats()->get_sales()', $backtrace );

	$args = array(
		'post_type'      => 'edd_payment',
		'nopaging'       => true,
		'year'           => $year,
		'fields'         => 'ids',
		'post_status'    => array( 'publish', 'revoked' ),
		'update_post_meta_cache' => false,
		'update_post_term_cache' => false
	);

	$show_free = apply_filters( 'edd_sales_by_date_show_free', true, $args );

	if ( false === $show_free ) {
		$args['meta_query'] = array(
			array(
				'key' => '_edd_payment_total',
				'value' => 0,
				'compare' => '>',
				'type' => 'NUMERIC',
			),
		);
	}

	if ( ! empty( $month_num ) )
		$args['monthnum'] = $month_num;

	if ( ! empty( $day ) )
		$args['day'] = $day;

	if ( ! empty( $hour ) )
		$args['hour'] = $hour;

	$args = apply_filters( 'edd_get_sales_by_date_args', $args  );

	$cached = get_transient( 'edd_stats_sales' );
	$key    = md5( json_encode( $args ) );

	if ( ! isset( $cached[ $key ] ) ) {
		$sales = new WP_Query( $args );
		$count = (int) $sales->post_count;

		// Cache the results for one hour
		$cached[ $key ] = $count;
		set_transient( 'edd_stats_sales', $cached, HOUR_IN_SECONDS );
	}

	$result = $cached[ $key ];

	return $result;
}

/**
 * Set the Page Style for PayPal Purchase page
 *
 * @since 1.4.1
 * @deprecated 2.8
 * @return string
 */
function edd_get_paypal_page_style() {

	$backtrace = debug_backtrace();

	_edd_deprecated_function( __FUNCTION__, '2.8', 'edd_get_paypal_image_url', $backtrace );

	$page_style = trim( edd_get_option( 'paypal_page_style', 'PayPal' ) );
	return apply_filters( 'edd_paypal_page_style', $page_style );
}

/**
 * Jilt Callback
 *
 * Renders Jilt Settings
 *
 * @deprecated 2.10.2
 *
 * @param array $args arguments passed by the setting.
 * @return void
 */
function edd_jilt_callback( $args ) {

	_edd_deprecated_function( __FUNCTION__, '2.10.2' );

	$activated   = is_callable( 'edd_jilt' );
	$connected   = $activated && edd_jilt()->get_integration()->is_jilt_connected();
	$connect_url = $activated ? edd_jilt()->get_connect_url() : '';
	$account_url = $connected ? edd_jilt()->get_integration()->get_jilt_app_url() : '';

	echo wp_kses_post( $args['desc'] );

	if ( $activated ) :
		?>

		<?php if ( $connected ) : ?>

		<p>
			<button id="edd-jilt-disconnect" class="button"><?php esc_html_e( 'Disconnect Jilt', 'easy-digital-downloads' ); ?></button>
		</p>

		<p>
			<?php
			wp_kses_post(
				sprintf(
				/* Translators: %1$s - <a> tag, %2$s - </a> tag */
					__( '%1$sClick here%2$s to visit your Jilt dashboard', 'easy-digital-downloads' ),
					'<a href="' . esc_url( $account_url ) . '" target="_blank">',
					'</a>'
				)
			);
			?>
		</p>

	<?php else : ?>

		<p>
			<a id="edd-jilt-connect" class="button button-primary" href="<?php echo esc_url( $connect_url ); ?>">
				<?php esc_html_e( 'Connect to Jilt', 'easy-digital-downloads' ); ?>
			</a>
		</p>

	<?php endif; ?>

	<?php elseif( current_user_can( 'install_plugins' ) ) : ?>

		<p>
			<button id="edd-jilt-connect" class="button button-primary">
				<?php esc_html_e( 'Install Jilt', 'easy-digital-downloads' ); ?>
			</button>
		</p>

	<?php
	endif;
}

/**
 * Handle installation and activation for Jilt via AJAX
 *
 * @deprecated 2.10.2
 * @since n.n.n
 */
function edd_jilt_remote_install_handler() {

	_edd_deprecated_function( __FUNCTION__, '2.10.2' );

	if ( ! current_user_can( 'manage_shop_settings' ) || ! current_user_can( 'install_plugins' ) ) {
		wp_send_json_error(
			array(
				'error' => __( 'You do not have permission to do this.', 'easy-digital-downloads' ),
			)
		);
	}

	include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	include_once ABSPATH . 'wp-admin/includes/file.php';
	include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

	$plugins = get_plugins();

	if ( ! array_key_exists( 'jilt-for-edd/jilt-for-edd.php', $plugins ) ) {
		/*
		* Use the WordPress Plugins API to get the plugin download link.
		*/
		$api = plugins_api(
			'plugin_information',
			array(
				'slug' => 'jilt-for-edd',
			)
		);

		if ( is_wp_error( $api ) ) {
			wp_send_json_error(
				array(
					'error' => $api->get_error_message(),
					'debug' => $api,
				)
			);
		}

		/*
		* Use the AJAX Upgrader skin to quietly install the plugin.
		*/
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );
		$install  = $upgrader->install( $api->download_link );
		if ( is_wp_error( $install ) ) {
			wp_send_json_error(
				array(
					'error' => $install->get_error_message(),
					'debug' => $api,
				)
			);
		}

		activate_plugin( $upgrader->plugin_info() );

	} else {

		activate_plugin( 'jilt-for-edd/jilt-for-edd.php' );
	}

	/*
	* Final check to see if Jilt is available.
	*/
	if ( ! class_exists( 'EDD_Jilt_Loader' ) ) {
		wp_send_json_error(
			array(
				'error' => __( 'Something went wrong. Jilt was not installed correctly.', 'easy-digital-downloads' ),
			)
		);
	}

	wp_send_json_success();
}

/**
 * Handle connection for Jilt via AJAX
 *
 * @deprecated 2.10.2
 * @since n.n.n
 */
function edd_jilt_connect_handler() {

	_edd_deprecated_function( __FUNCTION__, '2.10.2' );

	if ( ! current_user_can( 'manage_shop_settings' ) ) {
		wp_send_json_error(
			array(
				'error' => __( 'You do not have permission to do this.', 'easy-digital-downloads' ),
			)
		);
	}

	if ( ! is_callable( 'edd_jilt' ) ) {
		wp_send_json_error(
			array(
				'error' => __( 'Something went wrong. Jilt was not installed correctly.', 'easy-digital-downloads' ),
			)
		);
	}

	wp_send_json_success( array( 'connect_url' => edd_jilt()->get_connect_url() ) );
}

/**
 * Handle disconnection and deactivation for Jilt via AJAX
 *
 * @deprecated 2.10.2
 * @since n.n.n
 */
function edd_jilt_disconnect_handler() {

	_edd_deprecated_function( __FUNCTION__, '2.10.2' );

	if ( ! current_user_can( 'manage_shop_settings' ) ) {
		wp_send_json_error(
			array(
				'error' => __( 'You do not have permission to do this.', 'easy-digital-downloads' ),
			)
		);
	}

	if ( is_callable( 'edd_jilt' ) ) {

		edd_jilt()->get_integration()->unlink_shop();
		edd_jilt()->get_integration()->revoke_authorization();
		edd_jilt()->get_integration()->clear_connection_data();
	}

	deactivate_plugins( 'jilt-for-edd/jilt-for-edd.php' );

	wp_send_json_success();
}

/**
 * Maybe adds a notice to abandoned payments if Jilt isn't installed.
 *
 * @deprecated 2.10.2
 * @since n.n.n
 *
 * @param int $payment_id The ID of the abandoned payment, for which a jilt notice is being thrown.
 */
function maybe_add_jilt_notice_to_abandoned_payment( $payment_id ) {

	_edd_deprecated_function( __FUNCTION__, '2.10.2' );

	if ( ! is_callable( 'edd_jilt' )
		&& ! is_plugin_active( 'recapture-for-edd/recapture.php' )
		&& 'abandoned' === edd_get_payment_status( $payment_id )
		&& ! get_user_meta( get_current_user_id(), '_edd_try_jilt_dismissed', true )
	) {
		?>
		<div class="notice notice-warning jilt-notice">
			<p>
				<?php
				echo wp_kses_post(
					sprintf(
						/* Translators: %1$s - <strong> tag, %2$s - </strong> tag, %3$s - <a> tag, %4$s - </a> tag */
						__( '%1$sRecover abandoned purchases like this one.%2$s %3$sTry Jilt for free%4$s.', 'easy-digital-downloads' ),
						'<strong>',
						'</strong>',
						'<a href="https://easydigitaldownloads.com/downloads/jilt" target="_blank">',
						'</a>'
					)
				);
				?>
			</p>
			<?php
			echo wp_kses_post(
				sprintf(
					/* Translators: %1$s - Opening anchor tag, %2$s - The url to dismiss the ajax notice, %3$s - Complete the opening of the anchor tag, %4$s - Open span tag, %4$s - Close span tag */
					__( '%1$s %2$s %3$s %4$s Dismiss this notice. %5$s', 'easy-digital-downloads' ),
					'<a href="',
					esc_url(
						add_query_arg(
							array(
								'edd_action' => 'dismiss_notices',
								'edd_notice' => 'try_jilt',
							)
						)
					),
					'" type="button" class="notice-dismiss">',
					'<span class="screen-reader-text">',
					'</span>
				</a>'
				)
			);
			?>
		</div>
		<?php
	}
}

/**
 * SendWP Callback
 *
 * Renders SendWP Settings
 *
 * @since 2.9.15
 * @param array $args Arguments passed by the setting
 * @return void
 */
function edd_sendwp_callback( $args ) {

	_edd_deprecated_function( __FUNCTION__, '2.11.4' );

	// Connection status partial label based on the state of the SendWP email sending setting (Tools -> SendWP)
	$connected  = '<a href="https://app.sendwp.com/dashboard" target="_blank" rel="noopener noreferrer">';
	$connected .= __( 'Access your SendWP account', 'easy-digital-downloads' );
	$connected .= '</a>.';

	$disconnected = sprintf(
		__( '<em><strong>Note:</strong> Email sending is currently disabled. <a href="' . admin_url( '/tools.php?page=sendwp' ) . '">Click here</a> to enable it.</em>', 'easy-digital-downloads' )
	);

	// Checks if SendWP is connected
	$client_connected = function_exists( 'sendwp_client_connected' ) && sendwp_client_connected() ? true : false;

	// Checks if email sending is enabled in SendWP
	$forwarding_enabled = function_exists( 'sendwp_forwarding_enabled' ) && sendwp_forwarding_enabled() ? true : false;

	ob_start();

	echo $args['desc'];

	// Output the appropriate button and label based on connection status
	if( $client_connected ) :
		?>
		<div class="inline notice notice-success">
			<p><?php _e( 'SendWP plugin activated.', 'easy-digital-downloads' ); ?> <?php echo $forwarding_enabled ? $connected : $disconnected ; ?></p>

			<p>
				<button id="edd-sendwp-disconnect" class="button"><?php _e( 'Disconnect SendWP', 'easy-digital-downloads' ); ?></button>
			</p>
		</div>
		<?php
	else :
		?>
		<p>
			<?php _e( 'We recommend SendWP to ensure quick and reliable delivery of all emails sent from your store, such as purchase receipts, subscription renewal reminders, password resets, and more.', 'easy-digital-downloads' ); ?> <?php printf( __( '%sLearn more%s', 'easy-digital-downloads' ), '<a href="https://sendwp.com/" target="_blank" rel="noopener noreferrer">', '</a>' ); ?>
		</p>
		<p>
			<button type="button" id="edd-sendwp-connect" class="button button-primary"><?php esc_html_e( 'Connect with SendWP', 'easy-digital-downloads' ); ?>
			</button>
		</p>

		<?php
	endif;

	echo ob_get_clean();
}

/**
 * Handle installation and connection for SendWP via ajax
 *
 * @since 2.9.15
 */
function edd_sendwp_remote_install_handler () {

	_edd_deprecated_function( __FUNCTION__, '2.11.4' );

	if ( ! current_user_can( 'manage_shop_settings' ) ) {
		wp_send_json_error( array(
			'error' => __( 'You do not have permission to do this.', 'easy-digital-downloads' )
		) );
	}

	include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	include_once ABSPATH . 'wp-admin/includes/file.php';
	include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

	$plugins = get_plugins();

	if( ! array_key_exists( 'sendwp/sendwp.php', $plugins ) ) {

		/*
		* Use the WordPress Plugins API to get the plugin download link.
		*/
		$api = plugins_api( 'plugin_information', array(
			'slug' => 'sendwp',
		) );

		if ( is_wp_error( $api ) ) {
			wp_send_json_error( array(
				'error' => $api->get_error_message(),
				'debug' => $api
			) );
		}

		/*
		* Use the AJAX Upgrader skin to quietly install the plugin.
		*/
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );
		$install = $upgrader->install( $api->download_link );
		if ( is_wp_error( $install ) ) {
			wp_send_json_error( array(
				'error' => $install->get_error_message(),
				'debug' => $api
			) );
		}

		$activated = activate_plugin( $upgrader->plugin_info() );

	} else {

		$activated = activate_plugin( 'sendwp/sendwp.php' );

	}

	/*
	* Final check to see if SendWP is available.
	*/
	if( ! function_exists('sendwp_get_server_url') ) {
		wp_send_json_error( array(
			'error' => __( 'Something went wrong. SendWP was not installed correctly.', 'easy-digital-downloads' )
		) );
	}

	wp_send_json_success( array(
		'partner_id'      => 81,
		'register_url'    => sendwp_get_server_url() . '_/signup',
		'client_name'     => sendwp_get_client_name(),
		'client_secret'   => sendwp_get_client_secret(),
		'client_redirect' => admin_url( '/edit.php?post_type=download&page=edd-settings&tab=emails&edd-message=sendwp-connected' ),
	) );
}
add_action( 'wp_ajax_edd_sendwp_remote_install', 'edd_sendwp_remote_install_handler' );

/**
 * Handle deactivation of SendWP via ajax
 *
 * @since 2.9.15
 */
function edd_sendwp_disconnect () {

	_edd_deprecated_function( __FUNCTION__, '2.11.4' );

	if ( ! current_user_can( 'manage_shop_settings' ) ) {
		wp_send_json_error( array(
			'error' => __( 'You do not have permission to do this.', 'easy-digital-downloads' )
		) );
	}

	sendwp_disconnect_client();

	deactivate_plugins( 'sendwp/sendwp.php' );

	wp_send_json_success();
}
add_action( 'wp_ajax_edd_sendwp_disconnect', 'edd_sendwp_disconnect' );

/**
 * Reverts to the original download URL validation.
 *
 * @since 2.11.4
 * @todo  Remove this function in 3.0.
 *
 * @param bool   $ret
 * @param string $url
 * @param array  $query_args
 * @param string $original_url
 */
add_filter( 'edd_validate_url_token', function( $ret, $url, $query_args, $original_url ) {
	// If the URL is already validated, we don't need to validate it again.
	if ( $ret ) {
		return $ret;
	}
	$allowed = edd_get_url_token_parameters();
	$remove  = array();
	foreach ( $query_args as $key => $value ) {
		if ( ! in_array( $key, $allowed, true ) ) {
			$remove[] = $key;
		}
	}

	if ( ! empty( $remove ) ) {
		$original_url = remove_query_arg( $remove, $original_url );
	}

	return isset( $query_args['token'] ) && hash_equals( $query_args['token'], edd_get_download_token( $original_url ) );
}, 10, 4 );

/**
 * Get the path of the Product Reviews plugin
 *
 * @since 2.9.20
 *
 * @return mixed|string
 */
function edd_reviews_location() {

	_edd_deprecated_function( __FUNCTION__, '2.11.4' );

	$possible_locations = array( 'edd-reviews/edd-reviews.php', 'EDD-Reviews/edd-reviews.php' );
	$reviews_location   = '';

	foreach ( $possible_locations as $location ) {

		if ( 0 !== validate_plugin( $location ) ) {
			continue;
		}
		$reviews_location = $location;
	}

	return $reviews_location;
}

/**
 * Outputs a metabox for the Product Reviews extension to show or activate it.
 *
 * @since 2.8
 * @return void
 */
function edd_render_review_status_metabox() {

	_edd_deprecated_function( __FUNCTION__, '2.11.4' );

	$reviews_location = edd_reviews_location();
	$is_promo_active  = edd_is_promo_active();

	ob_start();

	if ( ! empty( $reviews_location ) ) {
		$review_path  = '';
		$base_url     = wp_nonce_url( admin_url( 'plugins.php' ), 'activate-plugin_' . $reviews_location );
		$args         = array(
			'action'        => 'activate',
			'plugin'        => sanitize_text_field( $reviews_location ),
			'plugin_status' => 'all',
		);
		$activate_url = add_query_arg( $args, $base_url );
		?><p style="text-align: center;"><a href="<?php echo esc_url( $activate_url ); ?>" class="button-secondary"><?php _e( 'Activate Reviews', 'easy-digital-downloads' ); ?></a></p><?php

	} else {

		// Adjust UTM params based on state of promotion.
		if ( true === $is_promo_active ) {
			$args = array(
				'utm_source'   => 'download-metabox',
				'utm_medium'   => 'wp-admin',
				'utm_campaign' => 'bfcm2019',
				'utm_content'  => 'product-reviews-metabox-bfcm',
			);
		} else {
			$args = array(
				'utm_source'   => 'edit-download',
				'utm_medium'   => 'enable-reviews',
				'utm_campaign' => 'admin',
			);
		}

		$base_url = 'https://easydigitaldownloads.com/downloads/product-reviews';
		$url      = add_query_arg( $args, $base_url );
		?>
		<p>
			<?php
			// Translators: The %s represents the link to the Product Reviews extension.
			echo wp_kses_post( sprintf( __( 'Would you like to enable reviews for this product? Check out our <a target="_blank" href="%s">Product Reviews</a> extension.', 'easy-digital-downloads' ), esc_url( $url ) ) );
			?>
		</p>
		<?php
		// Add an additional note if a promotion is active.
		if ( true === $is_promo_active ) {
			?>
			<p>
				<?php echo wp_kses_post( __( 'Act now and <strong>SAVE 25%</strong> on your purchase. Sale ends <em>23:59 PM December 6th CST</em>. Use code <code>BFCM2019</code> at checkout.', 'easy-digital-downloads' ) ); ?>
			</p>
			<?php
		}
	}

	$rendered = ob_get_contents();
	ob_end_clean();

	echo wp_kses_post( $rendered );
}
