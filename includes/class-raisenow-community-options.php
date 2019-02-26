<?php


class Raisenow_Community_Options {
	
	/**
	 * a code editor will be instantiated for every item in the array.
	 * each item must contain an other array with the keys 'id' and 'type',
	 * whereas the id refers to the textareas id, that should be replaced with
	 * the editor and the type refers to the mime type of the code.
	 *
	 * @var array
	 */
	private $code_editor_config;
	
	/**
	 * Initialize some custom settings
	 */
	public function init() {
		// General Options
		register_setting( RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_options' );

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			__( 'General Options', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'general_options_section_header' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_test_mode',
			__( 'Turn on test mode for the forms', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_general_options_checkbox' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'test_mode',
				'helptext'  => "<p>" . __( 'Turn on test mode for the forms. No real transactions possible and debug information is printed to the page. Only use this setting if RaiseNow is also in test mode.', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_api_key',
			__( 'RaiseNow API key', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_api_key_option' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'api_key',
				'helptext'  => "<p>" . __( 'Your RaiseNow API key. Can be overridden in individual shortcodes if allowed (see setting below).', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_allow_shortcode_apikey',
			__( 'Allow the API key set above to be overridden in shortcodes', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_general_options_checkbox' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'allow_shortcode_apikey',
				'helptext'  => "<p>" . __( 'The API key for RaiseNow set above can be overridden in shortcodes if this setting is on. Check this box if your website uses multiple RaiseNow contracts (or for backwards compatibility).', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_default_minimum_onetime',
			__( 'Default minimum amount for one time donations', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_general_options_textinput' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'minimum_amount_onetime',
				'helptext'  => "<p>" . __( 'Minimum amount that can be donated in the forms for onetime donations. This is the default value that can be overridden in shortcodes. ', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_default_onetime_amounts',
			__( 'Default amounts for one time donations (comma separated list)', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_general_options_textinput' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'onetime_amounts',
				'helptext'  => "<p>" . __( 'Comma separated list of preset amounts for one time donations. This is the default value that can be overridden in shortcodes. ', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_default_default_amount',
			__( 'The preselected default amount in the form.', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_general_options_textinput' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'default_amount',
				'helptext'  => "<p>" . __( 'Of the above default amounts, enter one that will be preselected in the form. This is the default value that can be overridden in shortcodes. ', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_default_minimum_monthly',
			__( 'Default minimum amount for recurring donations (monthly)', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_general_options_textinput' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'minimum_amount_monthly',
				'helptext'  => "<p>" . __( 'Minimum amount that can be donated in the forms for monthly recurring donations. This is the default value that can be overridden in shortcodes. PLEASE NOTE: specify a monthly value, all other recurring periods will be calculated, for example yearly will be 12 times this value.', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_default_recurring_amounts',
			__( 'Default amounts for recurring donations (comma separated list)', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_general_options_textinput' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'recurring_amounts',
				'helptext'  => "<p>" . __( 'Comma separated list of preset amounts for recurring donations. This is the default value that can be overridden in shortcodes.', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_default_recurring_interval',
			__( 'Default recurring interval', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_general_options_textinput' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_general_section',
			[
				'option_id' => 'default_recurring_interval',
				'helptext'  => "<p>" . __( 'What interval should be preselected when users select recurring donations? Valid values are: weekly, monthly, quarterly, semestral, yearly.', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);

		// Widget Options
		register_setting( RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_widget_options' );

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_widget_section',
			__( 'Widget Options', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'widget_options_section_header' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		// Organisation Options
		register_setting( RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_organisation_options' );

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_organisation_section',
			__( 'Organisation Options', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'organisation_options_section_header' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);

		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_organisation',
			__( 'Select a supported Organisation', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_organisation_select' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_organisation_section',
			[
				'option_id' => 'organisation',
				'helptext'  => "",
			]
		);

		// Donation Options
		register_setting( RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_options' );

		add_settings_section(
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			__( 'Customize donation form', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'donation_options_section_header' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings'
		);
		
		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_javascript',
			__( 'Add custom script', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_custom_code_option' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'javascript',
				'helptext'  => "<p>" . __( 'Enter your javascript below. It will be applied to all donation forms.',
						RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);
		
		$this->add_code_editor_config( RAISENOW_COMMUNITY_PREFIX . '_donation_options-javascript', 'text/javascript' );
		
		add_settings_field(
			RAISENOW_COMMUNITY_PREFIX . '_css',
			__( 'Add custom css', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ),
			[ &$this, 'render_custom_code_option' ],
			RAISENOW_COMMUNITY_PREFIX . '_donation_settings',
			RAISENOW_COMMUNITY_PREFIX . '_donation_section',
			[
				'option_id' => 'css',
				'helptext'  => "<p>" . __( 'Enter your custom css below. It will be applied to all donation forms.',
						RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' ) . "</p>",
			]
		);
		
		$this->add_code_editor_config( RAISENOW_COMMUNITY_PREFIX . '_donation_options-css', 'text/css' );
	}
	
	public function donation_options_section_header() {
		echo __( 'Use the options below to customize your donation form.', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' );
	}

	public function widget_options_section_header() {
		echo __( 'Presets for donation widgets (can be overridden in each widget)', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' );
	}

	public function organisation_options_section_header() {
		echo __( 'Activate special options for supported organmisations', RAISENOW_COMMUNITY_PREFIX, 'raisenow-community' );
	}

	public function general_options_section_header() {
	}

	public function render_api_key_option( $args ) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_general_options';
		$options    = get_option( $options_id );

		if ( isset( $options[ $args['option_id'] ] ) ) {
			$input = $options[ $args['option_id'] ];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='{$input}'>";
	}

	public function render_general_options_textinput( $args ) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_general_options';
		$options    = get_option( $options_id );

		if ( isset( $options[ $args['option_id'] ] ) ) {
			$input = $options[ $args['option_id'] ];
		} else {
			$input = '';
		}

		echo $args['helptext'];
		echo "<input type='text' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='{$input}'>";
	}

	public function render_general_options_checkbox( $args ) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_general_options';
		$options    = get_option( $options_id );

		if ( isset( $options[ $args['option_id'] ] ) ) {
			$input = $options[ $args['option_id'] ];
		} else {
			$input = 0;
		}

		echo $args['helptext'];

		echo "<input type='checkbox' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}' value='1'" . checked( $input , 1, false)  . ">";
		
	}

	public function render_organisation_select( $args ) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_organisation_options';
		$options    = get_option( $options_id );
		
		$supportedOrganisations = array(
			'none' => 'No Organisation',
			'grueneschweiz' => 'Grüne Partei der Schweiz',
			'greenpeacech' => ' Greenpeace Switzerland',
		);

		$output = "<select name='{$options_id}[{$args['option_id']}]'>";

		foreach ($supportedOrganisations as $key => $name) {
			if ($key == $options[ $args['option_id'] ]) {
				$output .= '<option value="' . $key . '" selected="selected">' . $name . '</option>';
			}
			else {
				$output .= '<option value="' . $key . '">' . $name . '</option>';
			}
		}

		$output .= '</select>';

		echo $output;
	}
	
	public function render_custom_code_option( $args ) {
		$options_id = RAISENOW_COMMUNITY_PREFIX . '_donation_options';
		$options    = get_option( $options_id );
		
		if ( isset( $options[ $args['option_id'] ] ) ) {
			$input = $options[ $args['option_id'] ];
		} else {
			$input = '';
		}
		
		echo $args['helptext'];
		echo "<textarea style='resize: both;' name='{$options_id}[{$args['option_id']}]' id='$options_id-{$args['option_id']}'>$input</textarea>";
	}
	
	/**
	 * Add another code editor instance configuration
	 *
	 * @param string $id the id of the textarea that will be replaced with the code editor
	 * @param string $type the MIME type of the code
	 */
	private function add_code_editor_config( $id, $type ) {
		$this->code_editor_config[] = array(
			'id'   => $id,
			'type' => $type
		);
	}
	
	public function add_code_editor() {
		foreach ( $this->code_editor_config as $config ) {
			// Enqueue code editor and settings for manipulating script.
			$settings = wp_enqueue_code_editor( array( 'type' => $config['type'] ) );
			
			// Bail if user disabled CodeMirror.
			if ( false === $settings ) {
				return;
			}
			
			wp_add_inline_script(
				'code-editor',
				sprintf(
					"jQuery( function() { wp.codeEditor.initialize( '{$config['id']}', %s ); } );",
					wp_json_encode( $settings )
				)
			);
		}
	}
}