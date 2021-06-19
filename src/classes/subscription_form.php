<?php
class MailchimpSubscribeToDownloadForm{
    public function __construct() {
        add_action('wp_enqueue_scripts',array($this,'mailchimp_subscribe_to_download_load_scripts'));
        add_action('wp_enqueue_scripts',array($this,'mailchimp_subscribe_to_download_load_styles'));
        //Add form shortcode to WordPress
        add_shortcode( 'mcsub-form',  array( $this,'mailchimp_subscribe_to_download_form' ));
	}

    //Register Scripts to use 
    public function mailchimp_subscribe_to_download_load_scripts() {
       //loading php variables into javascript object to be used at ajax side
    $mailchimp_subscribe_to_download_options = get_option( 'mailchimp_subscribe_to_download_option_name' );
    $mailchimp_api_key_0 = $mailchimp_subscribe_to_download_options['mailchimp_api_key_0']; 
    $mailing_list_id_1 = $mailchimp_subscribe_to_download_options['mailing_list_id_1']; 
	  $server_id_2 = $mailchimp_subscribe_to_download_options['server_id_2']; 
    //$mcsd_download_link = $mcsd_atts['dlink'];
    $ajax_url = "https://".$server_id_2.".api.mailchimp.com/3.0/lists/".$mailing_list_id_1."/members/";

        wp_register_script('mcsd_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js');
        wp_register_script('mcsd_localjs', plugin_dir_url(__DIR__).'js/subscribe_to_download.js');
        wp_register_script('jqueryValidate', "https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js");
        wp_enqueue_script('mcsd_bootstrap');
		    wp_enqueue_script('jqueryValidate');
        wp_enqueue_script('mcsd_localjs');
		
		//putting the php variables into a javascript object to be used at the ajax side
		wp_localize_script( 'mcsd_localjs', 'mcsd_ajax_object', 
		array( 
		'ajax_url' => $ajax_url,
		'api_key' => $mailchimp_api_key_0
	  ) 
  );
    }

    public function mailchimp_subscribe_to_download_load_styles(){
    
        wp_register_style('mcsd_bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css');
		    wp_enqueue_style( 'load-fa', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css' );
        wp_enqueue_style('mcsd_bootstrap');
		    wp_enqueue_style('load-fa');
    }


    public function mailchimp_subscribe_to_download_form($atts=[]){//creating subscriber form
     
      $mcsd_atts = shortcode_atts( //setting shortcode attributes for created form
        array(
            'title' => '',
            'dlink'=>'',
			      'success_text_color'=>'#000',
			      'error_text_color'=>'#000',
            'button_text'=>'Download',
			      'uid'=>uniqid()
        ), $atts
      );

      $str= '<form id="mcsd_form_'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'" action="https://xxxxx.us#.list-manage1.com/subscribe/post" method="post">
                <input type="hidden" value='.esc_html__( $mcsd_atts['dlink'], 'mcsub-form' ).' id="dlk_'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'">
                <input type="hidden" value='.esc_html__( $mcsd_atts['success_text_color'], 'mcsub-form' ).' id="succtc'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'">
                <input type="hidden" value='.esc_html__( $mcsd_atts['error_text_color'], 'mcsub-form' ).' id="errtc'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'">
                <h2>'.esc_html__( $mcsd_atts['title'], 'mcsub-form' ).'</h2>
		
		
                <div class="form-row">
                    <h6 style="text-align:center;" class="mcsd_feedback_msg" id="mcsd_feedback_msg_'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'"></h5>
                    <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <label for="name">Name*</label>
                            <input type="text" name="FNAME" class="form-control" style="width:100%" id="nameInput_'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'" required>
                            
                          </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12 mb-3">
                            <div class="form-group">
                            <label for="email_address">Email address*</label>
                            <input type="text" name="EMAIL" class="form-control" style="width:100%" id="emailInput'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'" required>
                          </div>
                          </div>
                    </div>
                </div>
    
        <button type="submit" class="btn btn-primary mcsd_download_btn mb-3" id="'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'"><i class="fa fa-spinner fa-spin" style="display:none"></i>'.esc_html__( $mcsd_atts['button_text'], 'mcsub-form' ).'</button>
      </form>';
        
        //Return to display
        return $str;
    }

}


