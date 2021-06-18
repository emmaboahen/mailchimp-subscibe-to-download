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
			      'uid'=>uniqid()
        ), $atts
      );

      $str= '<form id="mcsd_form_'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'" action="https://gopeartech.us20.list-manage.com/subscribe/post" method="post">
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
                            <label for="organization">Organization*</label>
                            <input type="text" name="ORG" class="form-control" style="width:100%" id="organizationInput_'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'" required>
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
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                          <div class="form-group">
                          <label for="country">Country*</label>

                          <select name="COUNTRY" class="form-control" required id="countryInput'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'">
                                    <option value="" selected>Select a country</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                    <option value="AD">Andorra</option>
                                    <option value="AO">Angola</option>
                                    <option value="AI">Anguilla</option>
                                    <option value="AQ">Antarctica</option>
                                    <option value="AG">Antigua and Barbuda</option>
                                    <option value="AR">Argentina</option>
                                    <option value="AM">Armenia</option>
                                    <option value="AW">Aruba</option>
                                    <option value="AU">Australia</option>
                                    <option value="AT">Austria</option>
                                    <option value="AZ">Azerbaijan</option>
                                    <option value="BS">Bahamas</option>
                                    <option value="BH">Bahrain</option>
                                    <option value="BD">Bangladesh</option>
                                    <option value="BB">Barbados</option>
                                    <option value="BY">Belarus</option>
                                    <option value="BE">Belgium</option>
                                    <option value="BZ">Belize</option>
                                    <option value="BJ">Benin</option>
                                    <option value="BM">Bermuda</option>
                                    <option value="BT">Bhutan</option>
                                    <option value="BO">Bolivia</option>
                                    <option value="BA">Bosnia and Herzegowina</option>
                                    <option value="BW">Botswana</option>
                                    <option value="BV">Bouvet Island</option>
                                    <option value="BR">Brazil</option>
                                    <option value="IO">British Indian Ocean Territory</option>
                                    <option value="BN">Brunei Darussalam</option>
                                    <option value="BG">Bulgaria</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="BI">Burundi</option>
                                    <option value="KH">Cambodia</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CA">Canada</option>
                                    <option value="CV">Cape Verde</option>
                                    <option value="KY">Cayman Islands</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="TD">Chad</option>
                                    <option value="CL">Chile</option>
                                    <option value="CN">China</option>
                                    <option value="CX">Christmas Island</option>
                                    <option value="CC">Cocos (Keeling) Islands</option>
                                    <option value="CO">Colombia</option>
                                    <option value="KM">Comoros</option>
                                    <option value="CG">Congo</option>
                                    <option value="CD">Congo, the Democratic Republic of the</option>
                                    <option value="CK">Cook Islands</option>
                                    <option value="CR">Costa Rica</option>
                                    <option value="CI">Cote d\'Ivoire</option>
                                    <option value="HR">Croatia (Hrvatska)</option>
                                    <option value="CU">Cuba</option>
                                    <option value="CY">Cyprus</option>
                                    <option value="CZ">Czech Republic</option>
                                    <option value="DK">Denmark</option>
                                    <option value="DJ">Djibouti</option>
                                    <option value="DM">Dominica</option>
                                    <option value="DO">Dominican Republic</option>
                                    <option value="TP">East Timor</option>
                                    <option value="EC">Ecuador</option>
                                    <option value="EG">Egypt</option>
                                    <option value="SV">El Salvador</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ER">Eritrea</option>
                                    <option value="EE">Estonia</option>
                                    <option value="ET">Ethiopia</option>
                                    <option value="FK">Falkland Islands (Malvinas)</option>
                                    <option value="FO">Faroe Islands</option>
                                    <option value="FJ">Fiji</option>
                                    <option value="FI">Finland</option>
                                    <option value="FR">France</option>
                                    <option value="FX">France, Metropolitan</option>
                                    <option value="GF">French Guiana</option>
                                    <option value="PF">French Polynesia</option>
                                    <option value="TF">French Southern Territories</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GM">Gambia</option>
                                    <option value="GE">Georgia</option>
                                    <option value="DE">Germany</option>
                                    <option value="GH">Ghana</option>
                                    <option value="GI">Gibraltar</option>
                                    <option value="GR">Greece</option>
                                    <option value="GL">Greenland</option>
                                    <option value="GD">Grenada</option>
                                    <option value="GP">Guadeloupe</option>
                                    <option value="GU">Guam</option>
                                    <option value="GT">Guatemala</option>
                                    <option value="GN">Guinea</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GY">Guyana</option>
                                    <option value="HT">Haiti</option>
                                    <option value="HM">Heard and Mc Donald Islands</option>
                                    <option value="VA">Holy See (Vatican City State)</option>
                                    <option value="HN">Honduras</option>
                                    <option value="HK">Hong Kong</option>
                                    <option value="HU">Hungary</option>
                                    <option value="IS">Iceland</option>
                                    <option value="IN">India</option>
                                    <option value="ID">Indonesia</option>
                                    <option value="IR">Iran (Islamic Republic of)</option>
                                    <option value="IQ">Iraq</option>
                                    <option value="IE">Ireland</option>
                                    <option value="IL">Israel</option>
                                    <option value="IT">Italy</option>
                                    <option value="JM">Jamaica</option>
                                    <option value="JP">Japan</option>
                                    <option value="JO">Jordan</option>
                                    <option value="KZ">Kazakhstan</option>
                                    <option value="KE">Kenya</option>
                                    <option value="KI">Kiribati</option>
                                    <option value="KP">Korea, Democratic People\'s Republic of</option>
                                    <option value="KR">Korea, Republic of</option>
                                    <option value="KW">Kuwait</option>
                                    <option value="KG">Kyrgyzstan</option>
                                    <option value="LA">Lao People\'s Democratic Republic</option>
                                    <option value="LV">Latvia</option>
                                    <option value="LB">Lebanon</option>
                                    <option value="LS">Lesotho</option>
                                    <option value="LR">Liberia</option>
                                    <option value="LY">Libyan Arab Jamahiriya</option>
                                    <option value="LI">Liechtenstein</option>
                                    <option value="LT">Lithuania</option>
                                    <option value="LU">Luxembourg</option>
                                    <option value="MO">Macau</option>
                                    <option value="MK">Macedonia, The Former Yugoslav Republic of</option>
                                    <option value="MG">Madagascar</option>
                                    <option value="MW">Malawi</option>
                                    <option value="MY">Malaysia</option>
                                    <option value="MV">Maldives</option>
                                    <option value="ML">Mali</option>
                                    <option value="MT">Malta</option>
                                    <option value="MH">Marshall Islands</option>
                                    <option value="MQ">Martinique</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="MU">Mauritius</option>
                                    <option value="YT">Mayotte</option>
                                    <option value="MX">Mexico</option>
                                    <option value="FM">Micronesia, Federated States of</option>
                                    <option value="MD">Moldova, Republic of</option>
                                    <option value="MC">Monaco</option>
                                    <option value="MN">Mongolia</option>
                                    <option value="MS">Montserrat</option>
                                    <option value="MA">Morocco</option>
                                    <option value="MZ">Mozambique</option>
                                    <option value="MM">Myanmar</option>
                                    <option value="NA">Namibia</option>
                                    <option value="NR">Nauru</option>
                                    <option value="NP">Nepal</option>
                                    <option value="NL">Netherlands</option>
                                    <option value="AN">Netherlands Antilles</option>
                                    <option value="NC">New Caledonia</option>
                                    <option value="NZ">New Zealand</option>
                                    <option value="NI">Nicaragua</option>
                                    <option value="NE">Niger</option>
                                    <option value="NG">Nigeria</option>
                                    <option value="NU">Niue</option>
                                    <option value="NF">Norfolk Island</option>
                                    <option value="MP">Northern Mariana Islands</option>
                                    <option value="NO">Norway</option>
                                    <option value="OM">Oman</option>
                                    <option value="PK">Pakistan</option>
                                    <option value="PW">Palau</option>
                                    <option value="PA">Panama</option>
                                    <option value="PG">Papua New Guinea</option>
                                    <option value="PY">Paraguay</option>
                                    <option value="PE">Peru</option>
                                    <option value="PH">Philippines</option>
                                    <option value="PN">Pitcairn</option>
                                    <option value="PL">Poland</option>
                                    <option value="PT">Portugal</option>
                                    <option value="PR">Puerto Rico</option>
                                    <option value="QA">Qatar</option>
                                    <option value="RE">Reunion</option>
                                    <option value="RO">Romania</option>
                                    <option value="RU">Russian Federation</option>
                                    <option value="RW">Rwanda</option>
                                    <option value="KN">Saint Kitts and Nevis</option> 
                                    <option value="LC">Saint LUCIA</option>
                                    <option value="VC">Saint Vincent and the Grenadines</option>
                                    <option value="WS">Samoa</option>
                                    <option value="SM">San Marino</option>
                                    <option value="ST">Sao Tome and Principe</option> 
                                    <option value="SA">Saudi Arabia</option>
                                    <option value="SN">Senegal</option>
                                    <option value="SC">Seychelles</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="SG">Singapore</option>
                                    <option value="SK">Slovakia (Slovak Republic)</option>
                                    <option value="SI">Slovenia</option>
                                    <option value="SB">Solomon Islands</option>
                                    <option value="SO">Somalia</option>
                                    <option value="ZA">South Africa</option>
                                    <option value="GS">South Georgia and the South Sandwich Islands</option>
                                    <option value="ES">Spain</option>
                                    <option value="LK">Sri Lanka</option>
                                    <option value="SH">St. Helena</option>
                                    <option value="PM">St. Pierre and Miquelon</option>
                                    <option value="SD">Sudan</option>
                                    <option value="SR">Suriname</option>
                                    <option value="SJ">Svalbard and Jan Mayen Islands</option>
                                    <option value="SZ">Swaziland</option>
                                    <option value="SE">Sweden</option>
                                    <option value="CH">Switzerland</option>
                                    <option value="SY">Syrian Arab Republic</option>
                                    <option value="TW">Taiwan, Province of China</option>
                                    <option value="TJ">Tajikistan</option>
                                    <option value="TZ">Tanzania, United Republic of</option>
                                    <option value="TH">Thailand</option>
                                    <option value="TG">Togo</option>
                                    <option value="TK">Tokelau</option>
                                    <option value="TO">Tonga</option>
                                    <option value="TT">Trinidad and Tobago</option>
                                    <option value="TN">Tunisia</option>
                                    <option value="TR">Turkey</option>
                                    <option value="TM">Turkmenistan</option>
                                    <option value="TC">Turks and Caicos Islands</option>
                                    <option value="TV">Tuvalu</option>
                                    <option value="UG">Uganda</option>
                                    <option value="UA">Ukraine</option>
                                    <option value="AE">United Arab Emirates</option>
                                    <option value="GB">United Kingdom</option>
                                    <option value="US">United States</option>
                                    <option value="UM">United States Minor Outlying Islands</option>
                                    <option value="UY">Uruguay</option>
                                    <option value="UZ">Uzbekistan</option>
                                    <option value="VU">Vanuatu</option>
                                    <option value="VE">Venezuela</option>
                                    <option value="VN">Viet Nam</option>
                                    <option value="VG">Virgin Islands (British)</option>
                                    <option value="VI">Virgin Islands (U.S.)</option>
                                    <option value="WF">Wallis and Futuna Islands</option>
                                    <option value="EH">Western Sahara</option>
                                    <option value="YE">Yemen</option>
                                    <option value="YU">Yugoslavia</option>
                                    <option value="ZM">Zambia</option>
                                    <option value="ZW">Zimbabwe</option>
                        </select>
                    </div>   
                  </div>

    
        <button type="submit" class="btn btn-primary mcsd_download_btn mb-3" id="'.esc_html__( $mcsd_atts['uid'], 'mcsub-form' ).'"><i class="fa fa-spinner fa-spin" style="display:none"></i> Download</button>
      </form>';
        
        //Return to display
        return $str;
    }

}


