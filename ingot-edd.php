<?php
/**
 Plugin Name: Ingot - Easy Digital Downloads
 Version: 1.0.0
Plugin URI:  http://IngotHQ.com
Description: EDD for Ingot
Author:      Ingot LLC
Author URI:  http://IngotHQ.com
 */
use ingot\addon\edd\add_destinations;
use ingot\addon\edd\tracking;

/**
 * Copyright 2016 Ingot LLC
 *
 * Licensed under the terms of the GNU General Public License version 2 or later
 */

/**
 * Make add-on go if not already loaded
 */
add_action( 'ingot_before', function(){
	if( ! defined( 'INGOT_EDD_VER' ) ) {
		define( 'INGOT_EDD_VER', '1.0.0' );
		require_once dirname( __FILE__ ) . '/vendor/autoload.php';

		/**
		 * Freemius setup
		 *
		 * @since 1.0.0
		 *
		 * @return \Freemius
		 */
		function ingot_edd_fs() {
			global $ingot_edd_fs;

			if ( ! isset( $ingot_edd_fs ) ) {
				ingot_fs();
				$ingot_edd_fs = fs_dynamic_init( array(
					'id'                => '223',
					'slug'              => 'edd',
					'public_key'        => 'pk_432d5762f0117a9590536ef4739e9',
					'is_premium'        => true,
					'has_paid_plans'    => true,
					'is_org_compliant'  => false,
					'parent'      => array(
						'id'         => '210',
						'slug'       => 'ingot',
						'public_key' => 'pk_e6a19a3508bdb9bdc91a7182c8e0c',
						'name'       => 'Ingot',
					),
				) );
			}

			return $ingot_edd_fs;
		}

		/**
		 * Boot Freemius integration
		 */
		add_action( 'ingot_loaded', 'ingot_edd_fs', 25 );

		add_action( 'ingot_loaded', function(){
			new add_destinations();
			new tracking();
		}, 26 );

	}

});
