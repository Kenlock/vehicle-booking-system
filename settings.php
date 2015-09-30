<?php

class VBSSettings {
	private $vbs_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'vbs_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'vbs_settings_page_init' ) );
	}

	public function vbs_settings_add_plugin_page() {
		add_menu_page(
			'VBS Settings', // page_title
			'VBS Settings', // menu_title
			'manage_options', // capability
			'vbs-settings', // menu_slug
			array( $this, 'vbs_settings_create_admin_page' ), // function
			'dashicons-forms', // icon_url
			100 // position
		);
	}

	public function vbs_settings_create_admin_page() {
		$this->vbs_settings_options = get_option( 'vbs_settings_option_name' ); ?>

		<div class="wrap">
			<h2>VBS Settings</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'vbs_settings_option_group' );
					do_settings_sections( 'vbs-settings-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function vbs_settings_page_init() {
		register_setting(
			'vbs_settings_option_group', // option_group
			'vbs_settings_option_name', // option_name
			array( $this, 'vbs_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'vbs_settings_setting_section', // id
			'Settings', // title
			array( $this, 'vbs_settings_section_info' ), // callback
			'vbs-settings-admin' // page
		);

		// Paypal API mode
		add_settings_field(
			'paypal_mode', // id
			'PayPal Mode', // title
			array( $this, 'paypal_mode_callback' ), // callback
			'vbs-settings-admin', // page
			'vbs_settings_setting_section' // section
		);

		// Paypal API Username
		add_settings_field(
			'paypal_api_user', // id
			'PayPal API Username', // title
			array( $this, 'paypal_api_user_callback' ), // callback
			'vbs-settings-admin', // page
			'vbs_settings_setting_section' // section
		);

		// Paypal API password
		add_settings_field(
			'paypal_api_pass', // id
			'Paypal API password', // title
			array( $this, 'paypal_api_pass_callback' ), // callback
			'vbs-settings-admin', // page
			'vbs_settings_setting_section' // section
		);

		// Paypal API Signature
		add_settings_field(
			'paypal_api_sig', // id
			'Paypal API Signature', // title
			array( $this, 'paypal_api_sig_callback' ), // callback
			'vbs-settings-admin', // page
			'vbs_settings_setting_section' // section
		);

		// Paypal Currency Code
		add_settings_field(
			'paypal_cur', // id
			'Paypal Currency Code', // title
			array( $this, 'paypal_cur_callback' ), // callback
			'vbs-settings-admin', // page
			'vbs_settings_setting_section' // section
		);

		add_settings_field(
			'textarea_1', // id
			'Textarea', // title
			array( $this, 'textarea_1_callback' ), // callback
			'vbs-settings-admin', // page
			'vbs_settings_setting_section' // section
		);

		add_settings_field(
			'checkbox_3', // id
			'Checkbox', // title
			array( $this, 'checkbox_3_callback' ), // callback
			'vbs-settings-admin', // page
			'vbs_settings_setting_section' // section
		);

		add_settings_field(
			'radio_4', // id
			'Radio', // title
			array( $this, 'radio_4_callback' ), // callback
			'vbs-settings-admin', // page
			'vbs_settings_setting_section' // section
		);
	}

	public function vbs_settings_sanitize($input) {
		$sanitary_values = array();

		if ( isset( $input['paypal_mode'] ) ) {
			$sanitary_values['paypal_mode'] = $input['paypal_mode'];
		}

		if ( isset( $input['paypal_api_user'] ) ) {
			$sanitary_values['paypal_api_user'] = sanitize_text_field( $input['paypal_api_user'] );
		}

		if ( isset( $input['paypal_api_pass'] ) ) {
			$sanitary_values['paypal_api_pass'] = sanitize_text_field( $input['paypal_api_pass'] );
		}

		if ( isset( $input['paypal_api_sig'] ) ) {
			$sanitary_values['paypal_api_sig'] = sanitize_text_field( $input['paypal_api_sig'] );
		}

		if ( isset( $input['paypal_cur'] ) ) {
			$sanitary_values['paypal_cur'] = sanitize_text_field( $input['paypal_cur'] );
		}

		if ( isset( $input['textarea_1'] ) ) {
			$sanitary_values['textarea_1'] = esc_textarea( $input['textarea_1'] );
		}

		if ( isset( $input['checkbox_3'] ) ) {
			$sanitary_values['checkbox_3'] = $input['checkbox_3'];
		}

		if ( isset( $input['radio_4'] ) ) {
			$sanitary_values['radio_4'] = $input['radio_4'];
		}

		return $sanitary_values;
	}

	public function vbs_settings_section_info() {
		
	}

	public function paypal_mode_callback() {
		?> <select name="vbs_settings_option_name[paypal_mode]" id="paypal_mode">
			<?php $selected = (isset( $this->vbs_settings_options['paypal_mode'] ) && $this->vbs_settings_options['paypal_mode'] === 'live') ? 'selected' : '' ; ?>
			<option value="live" <?php echo $selected; ?>>Live</option>
			<?php $selected = (isset( $this->vbs_settings_options['paypal_mode'] ) && $this->vbs_settings_options['paypal_mode'] === 'sandbox') ? 'selected' : '' ; ?>
			<option value="sandbox" <?php echo $selected; ?>>Sandbox</option>
		</select> <?php
	}

	public function paypal_api_user_callback() {
		printf(
			'<input class="regular-text" type="text" name="vbs_settings_option_name[paypal_api_user]" id="paypal_api_user" value="%s">',
			isset( $this->vbs_settings_options['paypal_api_user'] ) ? esc_attr( $this->vbs_settings_options['paypal_api_user']) : ''
		);
	}

	public function paypal_api_pass_callback() {
		printf(
			'<input class="regular-text" type="text" name="vbs_settings_option_name[paypal_api_pass]" id="paypal_api_pass" value="%s">',
			isset( $this->vbs_settings_options['paypal_api_pass'] ) ? esc_attr( $this->vbs_settings_options['paypal_api_pass']) : ''
		);
	}

	public function paypal_api_sig_callback() {
		printf(
			'<input class="regular-text" type="text" name="vbs_settings_option_name[paypal_api_sig]" id="paypal_api_sig" value="%s">',
			isset( $this->vbs_settings_options['paypal_api_sig'] ) ? esc_attr( $this->vbs_settings_options['paypal_api_sig']) : ''
		);
	}

	public function paypal_cur_callback() {
		printf(
			'<input class="regular-text" type="text" name="vbs_settings_option_name[paypal_cur]" id="paypal_cur" value="%s">',
			isset( $this->vbs_settings_options['paypal_cur'] ) ? esc_attr( $this->vbs_settings_options['paypal_cur']) : ''
		);
	}

	public function textarea_1_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="vbs_settings_option_name[textarea_1]" id="textarea_1">%s</textarea>',
			isset( $this->vbs_settings_options['textarea_1'] ) ? esc_attr( $this->vbs_settings_options['textarea_1']) : ''
		);
	}

	public function checkbox_3_callback() {
		printf(
			'<input type="checkbox" name="vbs_settings_option_name[checkbox_3]" id="checkbox_3" value="checkbox_3" %s> <label for="checkbox_3">Description for checkbox</label>',
			( isset( $this->vbs_settings_options['checkbox_3'] ) && $this->vbs_settings_options['checkbox_3'] === 'checkbox_3' ) ? 'checked' : ''
		);
	}

	public function radio_4_callback() {
		?> <fieldset><?php $checked = ( isset( $this->vbs_settings_options['radio_4'] ) && $this->vbs_settings_options['radio_4'] === 'radio_option1' ) ? 'checked' : '' ; ?>
		<label for="radio_4-0"><input type="radio" name="vbs_settings_option_name[radio_4]" id="radio_4-0" value="radio_option1" <?php echo $checked; ?>> Option One</label><br>
		<?php $checked = ( isset( $this->vbs_settings_options['radio_4'] ) && $this->vbs_settings_options['radio_4'] === 'radio_option2' ) ? 'checked' : '' ; ?>
		<label for="radio_4-1"><input type="radio" name="vbs_settings_option_name[radio_4]" id="radio_4-1" value="radio_option2" <?php echo $checked; ?>> Option Two</label></fieldset> <?php
	}

}

if ( is_admin() )
		$vbs_settings = new VBSSettings();

/* 
 * Retrieve this value with:
 * $vbs_settings_options = get_option( 'vbs_settings_option_name' ); // Array of All Options
 * $text_0 = $vbs_settings_options['text_0']; // Text
 * $textarea_1 = $vbs_settings_options['textarea_1']; // Textarea
 * $select_2 = $vbs_settings_options['select_2']; // Select
 * $checkbox_3 = $vbs_settings_options['checkbox_3']; // Checkbox
 * $radio_4 = $vbs_settings_options['radio_4']; // Radio
 */