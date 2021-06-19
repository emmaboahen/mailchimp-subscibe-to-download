# Mailchimp: Subscribe To Download
This is a wordpress plugin which helps you to capture subscribers from your wordpress website into your mailchimp mailing list in exchange for some freebies(pdf,music,video etc.) to download after successful subscription.

## Installation
1. Go to plugins link on your wordpress dashboard and click add new
2. Upload your plugin file from the plugin folder in the repo and click install
3. Activate the plugin

## Settings
1. Click on the plugin settings link from your dashboard (Link name: Mailchimp: Subscribe To Download)
2. Create an audience list and api key in your mailchimp account
3. Enter your api key and mailing list id in the plugin settings on your wordpress dashboard
4. Enter your server id. Usually when you login to mailchimp, your dashboard link looks like this "https://[SERVER_ID].admin.mailchimp.com/". Therefore if we have a link like "https://us20.admin.mailchimp.com/", our server id will be `us20`.

## Shortcodes

### Form Shortcode
Enter the shortcode [mcsub-form] on any part of your page to render the subscription form

### Shortcode Attributes
| Attribute | Description  |
| --- | --- |
| `title` | Form title your wish to use|
| `dlink` | Download link to the file you wish to give to your subscribers after a successful subscription |
| `success_text_color` | Preferred color for success message after subscription |
| `error_text_color` | Preferred color for error message during subscription |
| `button_text` | Text to show on your form's submit button |

#### Full example of shortcode in use:
[mcsub-form `title`="My Test Form" `dlink`="your file download link" `success_text_color`="green" `error_text_color`="red" `button_text`="Subscribe"]









