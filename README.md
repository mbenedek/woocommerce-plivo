WooCommerce Plivo Plugin
========================
This plugin for WordPress WooCommerce enables the use of the popular platform for building voice and SMS enabled applications, [Plivo](http://www.plivo.com/?utm_source=plivo-plugin&utm_medium=github&utm_campaign=siteoptimo). We aim to integrate most of the features the Plivo API has to offer, but for now, we'll stick to implementing SMS order notifications.

Current features:
* Auto send status updates
* Send a test SMS
* Add opt-in/opt-out on checkout
* Edit status SMS notifications
* Send an SMS from the order page
* WPML compatible

Extra customer trust
--------------------
Your customers will love it. Sending SMS notifications is a great way to let customers know the current order status and will increase positive reviews.
Get what the big boys are using and add a more physical dimension to the shop.

Powered by Plivo
----------------
Plivo is an awesome cloud based API platform for building Voice and SMS enabled applications. We make use of the Plivo API to send all the messages.
Support for over 200 countries and competitive pricing makes Plivo a nobrainer. Prices starting at $0,0065 per text!
Get started now by creating your [free trial account](https://console.plivo.com/accounts/register/?utm_source=plivo-plugin&utm_medium=wordpress&utm_campaign=siteoptimo).

Requirements
------------
To make use of the Plivo API, this plugin requires php-openssl, php-curl to be installed. Obviously, you'll need a Plivo account.

Installation
------------
Simply download the plugin from the WordPress plugin repository, or download the current working version from Github.

Extendable
----------
You can also add custom variables to the message that is being sent, you can it like this. 

    add_filter('wcp_variables', function($variables) {
        $variables['test'] = __('Test Description');
    
        return $variables;
    });
    
    add_filter('wcp_variable_values', function($values, $order_id) {
        $values['test'] = 'Your order ID is ' . $order_id;
    
        return $values;
    }, 10, 2);

Alternatively, you can also change the message altogether using the *wcp_order_status_changed_message* hook:

    add_filter('wcp_order_status_changed_message', function($message, $orderID, $newStatus) {
        
        // do magic
        
        return $message;    
    }, 10, 3);


About the authors & support
---------------------------
This plugin is written by the brave and handsome coders of [SiteOptimo](https://www.siteoptimo.com/?utm_source=plivo-plugin&utm_medium=github&utm_campaign=wcp).
We made it freely available for the WordPress and WooCommerce community. We might build more custom work in the future.

Issues
------
If you find an issue or if you have a suggestion for an improvement, [please let us know](https://github.com/siteoptimo/woocommerce-plivo/issues/new)!
