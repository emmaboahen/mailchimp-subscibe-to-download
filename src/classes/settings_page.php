<?php
class MailchimpSubscribeToDownloadSettings {
	private $mailchimp_subscribe_to_download_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'mailchimp_subscribe_to_download_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'mailchimp_subscribe_to_download_page_init' ) );
	}

	public function mailchimp_subscribe_to_download_add_plugin_page() {
		add_menu_page(
			'Mailchimp: Subscribe To Download', // page_title
			'Mailchimp: Subscribe To Download', // menu_title
			'manage_options', // capability
			'mailchimp-subscribe-to-download', // menu_slug
			array( $this, 'mailchimp_subscribe_to_download_create_admin_page' ), // function
			'dashicons-admin-generic', // icon_url
			2 // position
		);
	}

	public function mailchimp_subscribe_to_download_create_admin_page() {
		$this->mailchimp_subscribe_to_download_options = get_option( 'mailchimp_subscribe_to_download_option_name' ); ?>

		<div class="wrap">
			<h2>Mailchimp: Subscribe To Download</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'mailchimp_subscribe_to_download_option_group' );
					do_settings_sections( 'mailchimp-subscribe-to-download-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function mailchimp_subscribe_to_download_page_init() {
		register_setting(
			'mailchimp_subscribe_to_download_option_group', // option_group
			'mailchimp_subscribe_to_download_option_name', // option_name
			array( $this, 'mailchimp_subscribe_to_download_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'mailchimp_subscribe_to_download_setting_section', // id
			'Settings', // title
			array( $this, 'mailchimp_subscribe_to_download_section_info' ), // callback
			'mailchimp-subscribe-to-download-admin' // page
		);

		add_settings_field(
			'mailchimp_api_key_0', // id
			'Mailchimp API Key', // title
			array( $this, 'mailchimp_api_key_0_callback' ), // callback
			'mailchimp-subscribe-to-download-admin', // page
			'mailchimp_subscribe_to_download_setting_section' // section
		);

		add_settings_field(
			'mailing_list_id_1', // id
			'Mailing List ID', // title
			array( $this, 'mailing_list_id_1_callback' ), // callback
			'mailchimp-subscribe-to-download-admin', // page
			'mailchimp_subscribe_to_download_setting_section' // section
		);
		add_settings_field(
			'server_id_2', // id
			'Server ID', // title
			array( $this, 'server_id_2_callback' ), // callback
			'mailchimp-subscribe-to-download-admin', // page
			'mailchimp_subscribe_to_download_setting_section' // section
		);
	}

	public function mailchimp_subscribe_to_download_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['mailchimp_api_key_0'] ) ) {
			$sanitary_values['mailchimp_api_key_0'] = sanitize_text_field( $input['mailchimp_api_key_0'] );
		}

		if ( isset( $input['mailing_list_id_1'] ) ) {
			$sanitary_values['mailing_list_id_1'] = sanitize_text_field( $input['mailing_list_id_1'] );
		}
		
		if ( isset( $input['server_id_2'] ) ) {
			$sanitary_values['server_id_2'] = sanitize_text_field( $input['server_id_2'] );
		}

		return $sanitary_values;
	}

	public function mailchimp_subscribe_to_download_section_info() {
		
	}

	public function mailchimp_api_key_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="mailchimp_subscribe_to_download_option_name[mailchimp_api_key_0]" id="mailchimp_api_key_0" value="%s">',
			isset( $this->mailchimp_subscribe_to_download_options['mailchimp_api_key_0'] ) ? esc_attr( $this->mailchimp_subscribe_to_download_options['mailchimp_api_key_0']) : ''
		);
	}

	public function mailing_list_id_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="mailchimp_subscribe_to_download_option_name[mailing_list_id_1]" id="mailing_list_id_1" value="%s">',
			isset( $this->mailchimp_subscribe_to_download_options['mailing_list_id_1'] ) ? esc_attr( $this->mailchimp_subscribe_to_download_options['mailing_list_id_1']) : ''
		);
	}
	
	public function server_id_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="mailchimp_subscribe_to_download_option_name[server_id_2]" id="server_id_2" value="%s">',
			isset( $this->mailchimp_subscribe_to_download_options['server_id_2'] ) ? esc_attr( $this->mailchimp_subscribe_to_download_options['server_id_2']) : ''
		);
	}

}


/* 
 * Retrieve this value with:
 * $mailchimp_subscribe_to_download_options = get_option( 'mailchimp_subscribe_to_download_option_name' ); // Array of All Options
 * $mailchimp_api_key_0 = $mailchimp_subscribe_to_download_options['mailchimp_api_key_0']; // Mailchimp API Key
 * $mailing_list_id_1 = $mailchimp_subscribe_to_download_options['mailing_list_id_1']; // Mailing List ID
 *$server_id_2 = $mailchimp_subscribe_to_download_options['server_id_1']; // Mailing List ID
 /

