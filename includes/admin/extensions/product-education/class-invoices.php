<?php
/**
 * Invoices
 *
 * Manages automatic installation/activation for Invoices.
 *
 * @package     EDD
 * @subpackage  Invoices
 * @copyright   Copyright (c) 2021, Easy Digital Downloads
 * @license     https://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.11.x
 */
namespace EDD\Admin\Settings;

use \EDD\Admin\Extensions\Extension;

class Invoices extends Extension {

	/**
	 * The product ID on EDD.
	 *
	 * @var integer
	 */
	protected $item_id = 375153;

	/**
	 * The EDD settings tab where this extension should show.
	 *
	 * @since 2.11.4
	 * @var string
	 */
	protected $settings_tab = 'gateways';

	/**
	 * The pass level required to access this extension.
	 */
	const PASS_LEVEL = \EDD\Admin\Pass_Manager::EXTENDED_PASS_ID;

	public function __construct() {
		add_filter( 'edd_settings_sections_gateways', array( $this, 'add_section' ) );
		add_action( 'edd_settings_tab_top_gateways_invoices', array( $this, 'settings_field' ) );
		add_action( 'edd_settings_tab_top_gateways_invoices', array( $this, 'hide_submit_button' ) );

		parent::__construct();
	}

	/**
	 * Gets the custom configuration for Invoices.
	 *
	 * @since 2.11.x
	 * @param array $product_data The array of product data from the API.
	 * @return array
	 */
	protected function get_configuration( $product_data = array() ) {
		return array(
			'style'       => 'horizontal',
			'title'       => __( 'Impress Your Customers with Custom Invoices', 'easy-digital-downloads' ),
			'description' => __( 'Allow your customers to download beautiful, professional invoices with one click!', 'easy-digital-downloads' ),
		);
	}

	/**
	 * Adds the Invoices Payments section to the settings.
	 *
	 * @param array $sections
	 * @return array
	 */
	public function add_section( $sections ) {
		if ( ! $this->is_edd_settings_screen() ) {
			return $sections;
		}
		if ( $this->is_activated() ) {
			return $sections;
		}

		$sections['invoices'] = __( 'Invoices', 'easy-digital-downloads' );

		return $sections;
	}

	/**
	 * Whether EDD Invoices active or not.
	 *
	 * @since 2.11.x
	 *
	 * @return bool True if Invoices is active.
	 */
	protected function is_activated() {
		if ( $this->manager->is_plugin_active( $this->get_product_data() ) ) {
			return true;
		}

		return class_exists( 'EDDInvoices' );
	}
}

new Invoices();
