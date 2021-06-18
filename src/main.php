<?php
/**
 * Plugin Name: Mailchimp: Subscribe To Download
 * Description: This plugin helps you to capture subscribers from your wordpress website into your mailing list by providing them with some freebies to download after successful subscription.
 * Version: 1.0.2
 * Author: Emmanuel N. Boahen
 * Author URI: https://www.linkedin.com/in/emmanuel-boahen-87779676/
 */

include('classes/settings_page.php');
include('classes/subscription_form.php');

$mailchimp_subscribe_to_download_form = new MailchimpSubscribeToDownloadForm();
if ( is_admin() )
	$mailchimp_subscribe_to_download_settings = new MailchimpSubscribeToDownloadSettings(); //creating settings page in backend admin area







