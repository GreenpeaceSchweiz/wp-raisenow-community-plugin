<?php


// Element Class 
class raisenowCommunityVCForm extends WPBakeryShortCode {

    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'vc_raisenowcommunityform_mapping' ) );
    }

    // Element Mapping
    public function vc_raisenowcommunityform_mapping() {
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }

        // Map the block with vc_map()
        vc_map( 
            array(
                'name' => __('RaiseNow Donation Form', RAISENOW_COMMUNITY_PREFIX),
                'base' => 'raisenowcommunityform',
                'description' => __('RaiseNow Donation Form', RAISENOW_COMMUNITY_PREFIX), 
                'category' => __('Donations', RAISENOW_COMMUNITY_PREFIX),   
                'icon' => RAISENOW_COMMUNITY_PATH . '/includes/visual-composer/assets/img/donations.png',            
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Donation Purpose', RAISENOW_COMMUNITY_PREFIX ),
                        'param_name' => 'purpose_key',
                        'value' => '',
                        'description' => __( 'The donation purpose as shown in RaiseNow', RAISENOW_COMMUNITY_PREFIX ),
                        'admin_label' => true,
                        'weight' => 0,
                        'group' => 'General',
                    ),
                    
                )
            )
        );  
    }                                                       
} 


// Element Class Init
new raisenowCommunityVCForm();
