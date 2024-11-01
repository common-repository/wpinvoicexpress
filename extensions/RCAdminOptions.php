<?php

Class RCAdminOptions implements Extension {


	public static function enable() {

		add_action( 'admin_init', [ __CLASS__, 'registerSettings' ] );

		add_action('admin_menu', function() {

			add_options_page( 'Invoicexpress', 'Invoicexpress', 'manage_options', 'rc_invoicexpress_options', [ __CLASS__, 'renderOptionsPage']);

		});

	}

	public static function registerSettings() {

		register_setting( 'pluginPage', 'wpie_settings' );

		add_settings_field(
			'api_key',
			__( 'Settings field description', 'wpie' ),
			null,
			'pluginPage',
			'wpie_pluginPage_section'
		);

		add_settings_field(
			'domain',
			__( 'Settings field description', 'wpie' ),
			null,
			'pluginPage',
			'wpie_pluginPage_section'
		);

	}

	public static function renderOptionsPage() {

		$options = get_option( 'wpie_settings' );

		RCCore::render('admin_options', [ 'options' => $options ]);

	}

}