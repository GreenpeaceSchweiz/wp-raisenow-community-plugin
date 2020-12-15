<?php

/**
 * lock out script kiddies: die on direct call
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Raisenow_Community_Frontend {
	/**
	 * Process shortcode for raise now donation forms
	 *
	 * Use [donation_form] with the required arguments 'api_key' and 'language'.
	 * Use the conditional arguments 'css' to add some custom styles and 'add_class'
	 * to append some custom classes.
	 *
	 * @param array $atts given from the add_shortcode function
	 *
	 * @return string
	 */
	public function donation_form( $atts ) {
		$return = '';

		$languages = [ 'de', 'fr', 'it', 'en' ];

		$generalOptions = get_option( RAISENOW_COMMUNITY_PREFIX . '_general_options' );
		$widgetOptions = get_option( RAISENOW_COMMUNITY_PREFIX . 'widget_options' );
		$organisationOptions = get_option( RAISENOW_COMMUNITY_PREFIX . '_organisation_options' );
		$donationOptions = get_option( RAISENOW_COMMUNITY_PREFIX . '_donation_options' );

		$internalTraffic = (array_key_exists('internal_traffic', $_COOKIE) && $_COOKIE['internal_traffic']) ?  1 : 0;

		// Unset attributes with empty content
		// shortcode_atts will not use the default values otherwise
		foreach ($atts as $key => $value) {
			if ($value == '') {
				unset($atts[$key]);
			}
		}

		extract(
			shortcode_atts(
				array(
					'api_key'   => '',
					//'hide_purpose' => '', // unused setting at the moment, purpose is hidden if purpose_key is set
					'purpose_key' => '',
					'purpose_text' => '',
					'language'  => '',
					'default_recurring_interval' => $generalOptions['default_recurring_interval'],
					'onetime_amounts'  => $generalOptions['onetime_amounts'],
					'recurring_amounts'  => $generalOptions['recurring_amounts'],
					'default_amount' => $generalOptions['default_amount'],
					'minimum_amount_onetime' => $generalOptions['minimum_amount_onetime'],
					'minimum_amount_monthly' => $generalOptions['minimum_amount_monthly'],
					'shorten_form' => false,
					'css'       => '',
					'class'     => 'raisenow_community_donation_form',
					'add_class' => '',
					'redirect_url_success' => '',
					'default_mode' => $generalOptions['default_mode'],

					// Organisation: greenpeace
					'stored_campaign_id' => '61621285', // projectId
					'stored_campaign_id_recurring' => '79528997',
					'stored_campaign_subid' => '29744', // paymentOptionId
					'stored_sxt_product_id' => '9229', // productId
					'stored_sxt_contract_template_id' => '', // contractTemplateId
				),
				$atts
			)
		);

		// Warn if test mode is on
		if ( key_exists('test_mode', $generalOptions) && $generalOptions['test_mode'] == 1 ) {
			$return .= '<p style="display:block;padding:1em 2em;background-color:red;color: white;font-weight: bold;">' . __( 'Test mode for the donation form is ON!', 'raisenow-community' ) . '</p>';

			$return .= print_r($atts, true) . "<br>";
			$return .= print_r($generalOptions, true) . "<br>";
			$return .= print_r($widgetOptions, true) . "<br>";
			$return .= print_r($organisationOptions, true) . "<br>";
			$return .= print_r($donationOptions, true) . "<br>";
		}

		// Setting the API key in shorcodes can be disabled in options. In  that case or if it's not set, the value set on the options should be used.
		if ( key_exists('allow_shortcode_apikey', $generalOptions) && $generalOptions['allow_shortcode_apikey'] != 1 || empty($api_key) ) {
			$api_key = $generalOptions['api_key'];
		}
		
		$api_key = trim( $api_key );

		if ( empty( $api_key ) ) {
			return '<div>' . sprintf( _x( 'Missing api key. Please set your API key either in the global options or in the shortcode. Shortcode must match the pattern: %s',
					'%s will be replaced with an example shortcode.', 'raisenow-community' ),
					'[donation_form api_key="API_KEY" language="LANG"]' ) . '</div>';
		}
		
		$language = trim( strtolower( $language ) );

		if ( ! in_array( $language, $languages ) ) {
			return '<div>' . sprintf( _x( 'Unknown language key in shortcode. Accepted values are %1$s. Shortcode must have the form: %2$s',
					'%1$s will be replaced with the accepted language keys. %2$s will be replaced with an example shortcode.',
					'raisenow-community' ), implode( ', ', $languages ),
					'[donation_form api_key="API_KEY" language="LANG"]' ) . '</div>';
		}

		$custom_css    = $donationOptions['css'];
		$custom_script = $donationOptions['javascript'];

		// Start generating the code
		$return .= '<div class="' . esc_attr( $class ) . ' ' . esc_attr( $add_class ) . '" style="' . esc_attr( $css ) . '">'
		       . '<div class="dds-widget-container" data-widget="lema"></div>'
		       . '<script language="javascript" src="https://widget.raisenow.com/widgets/lema/' . esc_attr( $api_key ) . '/js/dds-init-widget-' . esc_attr( $language ) . '.js" type="text/javascript"></script>'
		       . "<script>
					var gpchDonationItemName = '{$purpose_text}';
					var gpchDonationItemId = '{$stored_campaign_id}';
		       		var rnFormElements;
		       		var rnFormSummary;
			        window.rnwWidget = window.rnwWidget || {};
			        window.rnwWidget.configureWidget = window.rnwWidget.configureWidget || [];
			        window.rnwWidget.configureWidget.push(function(options) {
			";

		// Test mode: should only be used when RaiseNow is also in test mode
		if ( key_exists('test_mode', $generalOptions) && $generalOptions['test_mode'] == 1) {
			$return .= "
						// Set widget to test mode
						options.epikOptions.test_mode = 'true';
				";
		}

		$return .= "
						// Set GA ClientID & custom dimensions (but add the actual value later)
						options.defaults['stored_ga_clientids'] = '';
						options.defaults['stored_ga_custom_dimensions'] = '';
				";

		// Set the donation purpose as specified in options and hides the donation purpose in the form
		if ( !empty($purpose_key) && !empty($purpose_text) ) {
			$return .= "
						options.defaults['stored_rnw_purpose_text'] = '" . $purpose_text . "';
						options.defaults['stored_purpose'] = '" . $purpose_key . "';

						options.widget.on(window.rnwWidget.constants.events.WIDGET_LOADED, function(event) {
							// Hide donation purpose in the form
							event.widget.hideStep('donation-target');
						});
						
				";
		}

		if ($shorten_form) {
			$return .= '
						options.widget.on(window.rnwWidget.constants.events.PAGE_LOADED, function(event) {
							var rnform = document.getElementsByClassName("lema-full-form");
							rnFormElements = rnform[0].getElementsByClassName("lema-step lema-shown");
							rnFormSummary = document.getElementsByClassName("lema-summary-check");
							for(var i = 0; i < rnFormElements.length; i++) {
								if (i > 0) {
							    	rnFormElements[i].style.display = "none";
							    }
							}
							rnFormSummary[0].style.display = "none";
							document.getElementById("showFullRNFormButton").style.visibility = "visible";
							gpchDonationsAttachEventHandlers();
						});
			';
		}

		// Set custom one time amounts
		if ( !empty($onetime_amounts)) {
			$onetime_amounts = explode(',', $onetime_amounts);
			$amounts = array();
			foreach ($onetime_amounts as $amount) {
				$amounts[] = array(
					'text' => $amount,
					'value' => $amount * 100,
				);
			}
			$amounts = json_encode($amounts);

			$return .= "
				options.translations.step_amount.onetime_amounts = {$amounts};
				";
		}

		// Set custom recurring amounts
		if ( !empty($recurring_amounts)) {
			$recurring_amounts = explode(',', $recurring_amounts);
			$amounts = array();
			foreach ($recurring_amounts as $amount) {
				$amounts[] = array(
					'text' => $amount,
					'value' => $amount * 100,
				);
			}
			$amounts = json_encode($amounts);

			$return .= "
				options.translations.step_amount.recurring_amounts = {$amounts};
				";
		}

		// Set the default amount
		if ( !empty( $default_amount) ) {
			$default_amount = $default_amount * 100;
			$return .= "options.defaults['ui_onetime_amount_default'] = '{$default_amount}';" . "\n";
		}

		// Set the default recurring interval (weekly, monthly, quarterly, semestral, yearly)
		$allowed_values_interval = array('weekly', 'monthly', 'quarterly', 'semestral', 'yearly');

		// Set the default mode of the form to recurring
		if ($default_mode == 'recurring' && !empty( $default_recurring_interval) && in_array($default_recurring_interval, $allowed_values_interval ) ) {
			$return .= "options.defaults['recurring_interval'] = '{$default_recurring_interval}';" . "\n";

			// Set the options needed for a recurring interval
			$return .= "options.defaults['recurring_interval_name'] = '{$default_recurring_interval}';" . "\n";
			$return .= "options.defaults['ui_recurring_interval_default'] = '{$default_recurring_interval}';" . "\n";

			// The select-dropdown has to be touched for the interval change to be visible
			$return .= "
	            options.widget.on(
	              window.rnwWidget.constants.events.WIDGET_LOADED, function(event) {
	              event.widget.j('[name=\"interval-selector\"]').val(options.translations.common.quarterly).trigger('change');
                  dataLayer.push({
					'ecommerce': {
						'detail': {
							'products': [{
								'name': gpchDonationItemName,
								'id': gpchDonationItemId
							}]
						}
					}
				  });

	            }); ";
		}

		// Set minimum amounts for one time donations
		if ( !empty($minimum_amount_onetime)) {
			$return .= "
				options.widget.options.common.min_amount.single = {$minimum_amount_onetime};
				";
		}

		// Set minimum amounts for recurring donations
		if ( !empty($minimum_amount_monthly)) {
			$min_amount_weekly = ceil($minimum_amount_monthly / 4);
			$min_amount_quarterly = ceil($minimum_amount_monthly * 3);
			$min_amount_semestral = ceil($minimum_amount_monthly * 6);
			$min_amount_yearly = ceil($minimum_amount_monthly * 12);

			$return .= "
				options.widget.options.common.min_amount.recurring.weekly = {$min_amount_weekly};
				options.widget.options.common.min_amount.recurring.monthly = {$minimum_amount_monthly};
				options.widget.options.common.min_amount.recurring.quarterly = {$min_amount_quarterly};  
				options.widget.options.common.min_amount.recurring.semestral = {$min_amount_semestral};
				options.widget.options.common.min_amount.recurring.yearly = {$min_amount_yearly};
				";
		}

		$return .= "
			options.widget.on(window.rnwWidget.constants.events.PAYMENT_COMPLETE, function(event) {";

		// Push data into data layer
		$return .= "
                if(event.paymentStatus === 'success') {
                    dataLayer.push({
                        'event': 'donationSuccess',
                        'donation_purpose': event.payment.stored_rnw_purpose_text,
                        'donation_amount': event.payment.amount,
                        'donation_payment_method': event.payment.payment_method,
                        'donation_recurring_interval_name': event.payment.recurring_interval_name,
                        'donation_is_recurring': event.payment.meta_recurring,
                    });
                }
            ";

		// Add redirect URL if any
		if ( !empty($redirect_url_success) ) {
			$return .= "
                if(event.paymentStatus === 'success') {
                    // Redirect to another page
                    window.location = '" . $redirect_url_success . "'; 
                    event.widget.element.hide();
                }
            ";
		}

		$return .= "
			});";
		
		
		// Organisation: Grüne Partei Schweiz
		if ($organisationOptions['organisation'] == 'grueneschweiz') {
			$return .= "
			";
		}

		// Organisation: Greenpeace
		if ($organisationOptions['organisation'] == 'greenpeacech') {
			// Variables needed for Sextant
			$return .= "
				options.defaults['stored_campaign_id'] = '{$stored_campaign_id}'; // single
				options.defaults['stored_campaign_subid'] = '{$stored_campaign_subid}';
				options.defaults['stored_sxt_product_id'] = '{$stored_sxt_product_id}';
				";

			// Default for stored_sxt_contract_template_id is also set in RaiseNow, so if not set it's save to omit it. But if there's a value, we want to set it.
			if ( !empty($stored_sxt_contract_template_id)) {
				$return .= "
					options.defaults['stored_sxt_contract_template_id'] = '{$stored_sxt_contract_template_id}'; 
					";
			}

			// Set Sextant parameters and other Greenpeace specific options
			$return .= "
				var recurring = false;
				options.widget.on(window.rnwWidget.constants.events.DONATION_TYPE_CHANGED, function(event) {
					// if (event.value == true) then recurring else one-time
					if (event.value){
						// recurring
						recurring = true;
					} 
					else {
						// one-time
						recurring = false;
					}
				});

				options.widget.on(window.rnwWidget.constants.events.WIDGET_LOADED, function(event) {
					// Set default payment method
				   	event.widget.set('payment_method','vis');
				});

				options.widget.on(window.rnwWidget.constants.events.BEFORE_SUBMIT, function(event) {
					if (recurring){
						// Setzen der SEXTANT-Parameter
						event.widget.set('stored_campaign_id', '{$stored_campaign_id_recurring}'); // recurring
						event.widget.set('stored_campaign_subid', '');
						event.widget.set('stored_sxt_product_id', '{$stored_sxt_product_id}');
						// Man kann die contract template Uid überschreiben, im Connector aber schon vordefiniert
						// options.defaults['stored_sxt_contract_template_id'] = '507914'; 
					} else {
						event.widget.set('stored_campaign_id', '{$stored_campaign_id}'); // single
						event.widget.set('stored_campaign_subid', '{$stored_campaign_subid}');
						event.widget.set('stored_sxt_product_id', '');
					}
					
					// Analytics ClientIDs
					if (typeof gpchGAClientIds === 'object') {
						event.widget.set('stored_ga_clientids', JSON.stringify(gpchGAClientIds));
					}
					
					// Analytics additional data
					try {
						var gpch_ga_data = {
							'internal_traffic': " .  $internalTraffic . ",
							'tags': google_tag_manager[google_tag_value ].dataLayer.get('post_tags')
						};
						
						event.widget.set('stored_ga_custom_dimensions', JSON.stringify(gpch_ga_data));
					} catch (e) {}
				});

			";
		}

		

		$return .= "
			        });

			        // Shows the full form if it was shortened
			        function showFullRNForm() {
					    for(var i = 0; i < rnFormElements.length; i++) {
					        if (i > 0) {
					          rnFormElements[i].style.display = 'block';
					        }
					    }
					    rnFormSummary[0].style.display = 'block';
					    document.getElementById('showFullRNFormButton').style.display = 'none';
					}
			      </script>
			      <a class='btn btn-accent' id='showFullRNFormButton' onClick='showFullRNForm()' style='visibility: hidden;'>" . __( 'Next Step', 'raisenow-community' ) . "</a>";

		$return .= '<script type="text/javascript">' . $custom_script . '</script>'
		           . '<style type="text/css">' . $custom_css . '</style>'
		           . '</div>';

		$return .= $this->interactionEventScript();

		return $return;
	}

	protected function interactionEventScript() {
		$output = "<script type='text/javascript'>
		
		function gpchDonationsAttachEventHandlers() {
			// First form interaction
			var hasInteracted = false;
			
			document.querySelector('.raisenow_community_donation_form').addEventListener('click', function() {
				if (! hasInteracted) {
					dataLayer.push({
						'event': 'checkout',
						'ecommerce': {
							'checkout': {
								'actionField': {'step': 1},
								'products': [{
									'name': gpchDonationItemName,
									'id': gpchDonationItemId
								}]
							}
						}
					});

					hasInteracted = true;
				}
			}, false);
			
			// Next button click
			var nextButtonClicked = false;
			
			document.querySelector('#showFullRNFormButton').addEventListener('click', function() {
				if (! nextButtonClicked) {
					dataLayer.push({
						'event': 'checkout',
						'ecommerce': {
							'checkout': {
								'actionField': {'step': 2},
								'products': [{
									'name': gpchDonationItemName,
									'id': gpchDonationItemId
								}]
							}
						}
					});
					
					nextButtonClicked = true;
				}
			}, false);
			
			// Step payment options
			var paymentOptionClicked = false;
			
			var paymentElements1 = document.querySelectorAll('#greenpeace-ch-default-cardno');
			
			for (i = 0; i < paymentElements1.length; ++i) {
				paymentElements1[i].addEventListener('focus', sendStepPaymentEvent, false);
			}
			
			var paymentElements2 = document.querySelectorAll('.lema-step-payment-method .lema-accordion-header');
			
			for (i = 0; i < paymentElements2.length; ++i) {
				paymentElements2[i].addEventListener('click', sendStepPaymentEvent, false);
			}
	
			function sendStepPaymentEvent() {
				if (! paymentOptionClicked) {
					dataLayer.push({
						'event': 'checkout',
						'ecommerce': {
							'checkout': {
								'actionField': {'step': 3},
								'products': [{
									'name': gpchDonationItemName,
									'id': gpchDonationItemId
								}]
							}
						}
					});
					
					dataLayer.push({
						'event': 'checkoutOption',
						'ecommerce': {
							'checkout_option': {
								'actionField': {'step': 3, 'option': 'payment method'}
							}
						}
					});

					paymentOptionClicked = true;
				}
			}
			
			// Step customer identity interaction
			var customerIdentityClicked = false;
			
			document.querySelector('.lema-step-customer-identity input[type=text]').addEventListener('focus', function() {
				if (! customerIdentityClicked) {
					dataLayer.push({
						'event': 'checkout',
						'ecommerce': {
							'checkout': {
								'actionField': {'step': 4},
								'products': [{
									'name': gpchDonationItemName,
									'id': gpchDonationItemId
								}]
							}
						}
					});
					customerIdentityClicked = true;
				}
			}, false);
	
			// Step customer address
			var customerAddressClicked = false;
			
			document.querySelector('#greenpeace-ch-default-stored_customer_street').addEventListener('focus', function() {
				if (! customerAddressClicked) {
					dataLayer.push({
						'event': 'checkout',
						'ecommerce': {
							'checkout': {
								'actionField': {'step': 5},
								'products': [{
									'name': gpchDonationItemName,
									'id': gpchDonationItemId
								}]
							}
						}
					});
					customerAddressClicked = true;
				}
			}, false);
		}
		</script>";

		return $output;
	}
}