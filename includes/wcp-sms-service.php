<?php

if(!defined('ABSPATH')) exit;

require __DIR__.'/../library/vendor/autoload.php';

use Plivo\RestClient;

/**
 * Class WCP_SMS_Service
 *
 * Handles the sending of text messages.
 *
 * @package WooCommerce_Plivo
 * @class WCP_SMS_Service
 * @author Koen Van den Wijngaert <koen@siteoptimo.com>
 */
class WCP_SMS_Service
{
    /**
     * Single instance.
     * @var WCP_SMS_Service
     */
    private static $_instance = null;

    /**
     * @var string Plivo authentication ID.
     */
    private $auth_id;

    /**
     * @var string Plivo authentication token.
     */
    private $auth_token;

    /**
     * @var string "from" phone number.
     */
    private static $from = '123456789';

    /**
     * @var RestAPI The plivo API.
     */
    private $plivo;

    /**
     * Bootstraps the service.
     */
    public function __construct()
    {
        $this->populateAuthenticationInformation();

        if(empty($this->auth_token) || empty($this->auth_id))
        {
            throw new Exception("Can't start SMS Service. No Plivo credentials detected.");
        }

        try
        {
//            $this->plivo = new RestAPI($this->auth_id, $this->auth_token); // OLD METHOD
	        $this->plivo = new RestClient($this->auth_id, $this->auth_token);
        }
        catch(Exception $e)
        {
            throw new Exception("Can't start SMS Service. The Plivo credentials are invalid.");
        }

        self::$from = get_option('wcp_from_number', '+1-777-555-1234');

    }

    /**
     * Returns the WCP_SMS_Service instance.
     *
     * @return WCP_SMS_Service
     */
    public static function instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Populates the authentication data.
     */
    private function populateAuthenticationInformation()
    {
        $this->auth_id = get_option('wcp_auth_id');
        $this->auth_token = get_option('wcp_auth_password');
    }

    /**
     * Sends a text message.
     *
     * @param $to string The "to" number.
     * @param $message string The message.
     * @return bool Returns true on success, false on failure.
     */
    public function sendText($to, $message)
    {
    	// new method, REF: https://www.plivo.com/docs/sms/api/message#send-a-message
	    $response = $this->plivo->messages->create(
		    self::$from,
		    [$to],
		    $message
	    );

	    // first element, since we are sending just one message
	    $uuid = $response->getmessageUuid(0)[0];
	    sleep(1); // wait a second

	    $status = $this->plivo->messages->get($uuid);

	    $status = json_decode($status);

	    return in_array($status->message_state, array('queued', 'sent', 'delivered', 'received'));
    }
}