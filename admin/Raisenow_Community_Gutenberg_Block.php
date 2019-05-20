<?php

if ( ! class_exists( 'Raisenow_Community_Gutenberg_Block' ) ) {
	class Raisenow_Community_Gutenberg_Block {

		/**
		 * @var string $shortcode_name
		 */
		private static $shortcode_name = 'donation_form';

		public function __construct() {
			if ( function_exists( 'acf_add_local_field_group' ) ) {
				acf_add_local_field_group( array(
						'key'                   => 'group_p4_raisenow_block',
						'title'                 => 'RaiseNow Donation Form',
						'fields'                => array(
							array(
								'key'               => 'field_5ce2591c83127',
								'label'             => 'General Settings',
								'name'              => '',
								'type'              => 'tab',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'placement'         => 'top',
								'endpoint'          => 0,
							),
							array(
								'key'               => 'field_5ce2542b6a938',
								'label'             => 'Language',
								'name'              => 'language',
								'type'              => 'select',
								'instructions'      => '',
								'required'          => 1,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'choices'           => array(
									'de' => 'DE',
									'fr' => 'FR',
								),
								'default_value'     => array(
									0 => 'de',
								),
								'allow_null'        => 0,
								'multiple'          => 0,
								'ui'                => 0,
								'return_format'     => 'value',
								'ajax'              => 0,
								'placeholder'       => '',
							),
							array(
								'key'               => 'field_5ce252dd6a937',
								'label'             => 'Purpose Text',
								'name'              => 'purpose_text',
								'type'              => 'text',
								'instructions'      => 'The donation purpose will be shown to supporters in emails and other communication. Leave empty for general donations that are not related to a project.',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => 60,
							),
							array(
								'key'               => 'field_5ce2548d572cf',
								'label'             => 'Purpose Key',
								'name'              => 'purpose_key',
								'type'              => 'text',
								'instructions'      => 'The donation purpose as used internally in RaiseNow. Usually the same as the Purpose Text. Leave empty for general donations that are not related to a project.',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => 60,
							),
							array(
								'key'               => 'field_5ce254be572d0',
								'label'             => 'Shorten Form',
								'name'              => 'shorten_form',
								'type'              => 'true_false',
								'instructions'      => 'The shortened form will only display the amounts and a button to proceed.',
								'required'          => 1,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'message'           => '',
								'default_value'     => 1,
								'ui'                => 0,
								'ui_on_text'        => '',
								'ui_off_text'       => '',
							),
							array(
								'key'               => 'field_5ce255e1572d1',
								'label'             => 'Mode',
								'name'              => 'default_mode',
								'type'              => 'select',
								'instructions'      => 'Preselected mode (leave empty to use the global setting)',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'choices'           => array(
									'recurring' => 'Recurring Donations',
									'onetime'   => 'One-Off Donation',
								),
								'default_value'     => array(
									0 => 'recurring',
								),
								'allow_null'        => 0,
								'multiple'          => 0,
								'ui'                => 0,
								'return_format'     => 'value',
								'ajax'              => 0,
								'placeholder'       => '',
							),
							array(
								'key'               => 'field_5ce25678572d2',
								'label'             => 'Preselected Recurring Interval',
								'name'              => 'default_recurring_interval',
								'type'              => 'select',
								'instructions'      => 'Preselected frequency of donations (leave empty to use the global setting)',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'choices'           => array(
									'weekly'    => 'weekly',
									'monthly'   => 'monthly',
									'quarterly' => 'quarterly',
									'semestral' => 'semestral',
									'yearly'    => 'yearly',
								),
								'default_value'     => array(
									0 => 'yearly',
								),
								'allow_null'        => 0,
								'multiple'          => 0,
								'ui'                => 0,
								'return_format'     => 'value',
								'ajax'              => 0,
								'placeholder'       => '',
							),
							array(
								'key'               => 'field_5ce2592b83128',
								'label'             => 'Amounts',
								'name'              => '',
								'type'              => 'tab',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'placement'         => 'top',
								'endpoint'          => 0,
							),
							array(
								'key'               => 'field_5ce25a014fb05',
								'label'             => '',
								'name'              => '',
								'type'              => 'message',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'message'           => 'All of the amounts	can be left empty to use the default form values.',
								'new_lines'         => 'wpautop',
								'esc_html'          => 0,
							),
							array(
								'key'               => 'field_5ce2595d4fb02',
								'label'             => 'Default Amount',
								'name'              => 'default_amount',
								'type'              => 'number',
								'instructions'      => 'The preselected donation amount in the form.',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'min'               => 1,
								'max'               => '',
								'step'              => 1,
							),
							array(
								'key'               => 'field_5ce259954fb03',
								'label'             => 'Minimum amount for one-off donation',
								'name'              => 'minimum_amount_onetime',
								'type'              => 'number',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'min'               => 1,
								'max'               => '',
								'step'              => 1,
							),
							array(
								'key'               => 'field_5ce259bd4fb04',
								'label'             => 'One-Off donation amounts',
								'name'              => 'onetime_amounts',
								'type'              => 'text',
								'instructions'      => 'The amounts that appear on the buttons in the form for one time donations (Comma separated, example: 29,72,160,350)',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
							array(
								'key'               => 'field_5ce25a204fb06',
								'label'             => 'Minimum amount monthly',
								'name'              => 'minimum_amount_monthly',
								'type'              => 'number',
								'instructions'      => 'A minimum amount that users are allowed to set in the form for recurring donations (monthly amoount)',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'min'               => 1,
								'max'               => '',
								'step'              => - 1,
							),
							array(
								'key'               => 'field_5ce25a464fb07',
								'label'             => 'Recurring donation amounts',
								'name'              => 'recurring_amounts',
								'type'              => 'text',
								'instructions'      => 'The amounts that appear on the buttons in the form for recurring donations per month (Comma separated, example: 6,10,20,40,100).',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
							array(
								'key'               => 'field_5ce25a654fb08',
								'label'             => 'Greenpeace Sextant',
								'name'              => '',
								'type'              => 'tab',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'placement'         => 'top',
								'endpoint'          => 0,
							),
							array(
								'key'               => 'field_5ce25a854fb09',
								'label'             => 'Project ID',
								'name'              => 'stored_campaign_id',
								'type'              => 'text',
								'instructions'      => 'The project ID in Sextant for one time donations.',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
							array(
								'key'               => 'field_5ce25a994fb0a',
								'label'             => 'Project ID Recurring',
								'name'              => 'stored_campaign_id_recurring',
								'type'              => 'text',
								'instructions'      => 'The project ID in Sextant for recurring donations.',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
							array(
								'key'               => 'field_5ce25ab54fb0b',
								'label'             => 'Product ID',
								'name'              => 'stored_sxt_product_id',
								'type'              => 'text',
								'instructions'      => 'The product ID in Sextant.',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
							array(
								'key'               => 'field_5ce25acc4fb0c',
								'label'             => 'Payment Option ID',
								'name'              => 'stored_campaign_subid',
								'type'              => 'text',
								'instructions'      => 'The payment option ID in Sextant.',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
							array(
								'key'               => 'field_5ce25af24fb0d',
								'label'             => 'Extra',
								'name'              => '',
								'type'              => 'tab',
								'instructions'      => '',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'placement'         => 'top',
								'endpoint'          => 0,
							),
							array(
								'key'               => 'field_5ce25afe4fb0e',
								'label'             => 'Add class names',
								'name'              => 'add_class',
								'type'              => 'text',
								'instructions'      => 'Add an additional CSS class to the form.',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
								'prepend'           => '',
								'append'            => '',
								'maxlength'         => '',
							),
							array(
								'key'               => 'field_5ce25b104fb0f',
								'label'             => 'Thank you page URL',
								'name'              => 'redirect_url_success',
								'type'              => 'url',
								'instructions'      => 'If set, the page will redirect to this URL after successful donation. Leave empty for default behaviour (show thank you message in form).',
								'required'          => 0,
								'conditional_logic' => 0,
								'wrapper'           => array(
									'width' => '',
									'class' => '',
									'id'    => '',
								),
								'default_value'     => '',
								'placeholder'       => '',
							),
						),
						'location'              => array(
							array(
								array(
									'param'    => 'block',
									'operator' => '==',
									'value'    => 'acf/raisenow-donation-form',
								),
							),
						),
						'menu_order'            => 0,
						'position'              => 'normal',
						'style'                 => 'default',
						'label_placement'       => 'top',
						'instruction_placement' => 'label',
						'hide_on_screen'        => '',
						'active'                => true,
						'description'           => '',
					)
				);
			}

			add_action( 'acf/init', array( $this, 'init_acf_block' ) );
		}


		public function init_acf_block() {
			// check function exists
			if ( function_exists( 'acf_register_block' ) ) {

				// register the block
				acf_register_block( array(
					'name'            => 'raisenow-donation-form',
					'title'           => __( 'RaiseNow Donation Form', 'raisenow-community' ),
					'description'     => __( 'RaiseNow Donation Form (LEMA)', 'raisenow-community' ),
					'render_callback' => array( $this, 'block_callback' ),
					'category'        => 'gpch',
					'icon'            => 'money',
					'keywords'        => array( 'donation', 'form', 'raisenow' ),
				) );
			}
		}


		public function block_callback( $block ) {
			$fields = get_fields();

			// Shortcode parameters
			$parameters = $fields;

			// Generate Shortcode
			$shortcode = $this->generate_shortcode( self::$shortcode_name, $parameters );

			// Run shortcode only if it's registered (to prevent shortcodes from appearing in the frontend

			if ( is_admin() ) {
				// Preview in editor is difficult due to the form only loading through Javascript
				echo "<div style='min-height: 10rem; background-color: #eccad9; padding: 1rem;'><p><b>Donation Form:</b> No editor preview available</p><p>Click to edit</p></div>";
			} else {
				// Run shortcode only if it's registered (to prevent shortcodes from appearing in the frontend
				if ( shortcode_exists( self::$shortcode_name ) ) {
					echo $shortcode;
				}
			}


		}


		/**
		 * Generates a Wordpress shortcode
		 *
		 * @param string $shortcode_name
		 * @param array $parameters
		 * @param boolean $removeEmptyParameters : Removes empty parameters from shortcode
		 *
		 * @return string $shortcode
		 */
		public function generate_shortcode( $shortcode_name, $parameters, $removeEmptyParameters = false ) {
			$shortcode = '[' . $shortcode_name;

			foreach ( $parameters as $key => $value ) {
				if ( ! ( $removeEmptyParameters && empty( $value ) ) ) {
					$shortcode .= ' ' . $key . '="' . $value . '"';
				}
			}

			$shortcode .= ']';

			return $shortcode;
		}
	}
}

