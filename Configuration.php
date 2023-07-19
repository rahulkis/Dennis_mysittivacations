<?php 
class Configuration
{
	// For a full list of configuration parameters refer in wiki page (https://github.com/paypal/sdk-core-php/wiki/Configuring-the-SDK)
	public static function getConfig()
	{
		$config = array(
				// values: 'sandbox' for testing
				//		   'live' for production
				"mode" => 'live'
				//"mode" => 'sandbox'

				// These values are defaulted in SDK. If you want to override default values, uncomment it and add your value.
				// "http.ConnectionTimeOut" => "5000",
				// "http.Retry" => "2",
			);
		return $config;
	}

	// Creates a configuration array containing credentials and other required configuration parameters.
	public static function getAcctAndConfig()
	{
		$config = array(
				 //"acct1.UserName" => "merchant1315_api1.gmail.com",
				 //"acct1.Password" => "1404718419",
				 //"acct1.Signature" => "AiPC9BjkCyDFQXbSkoZcgqH3hpacAN2bS9Hg94MU0Jwj8PB.IEvmPybd",
				 //"acct1.AppId" => "APP-80W284485P519543T"

				"acct1.UserName" => "mysittidev.com_api1.gmail.com",
				"acct1.Password" => "NDUWRV5W9ZSR39HM",
				"acct1.Signature" => "AFcWxV21C7fd0v3bYYYRCpSSRl31Adx5ITc8eyefuMhYjHx.Me-HCeGj",
				"acct1.AppId" => "APP-51874512YR187274A"
		
				// Sandbox Email Address
				//"service.SandboxEmailAddress" => "pp.devtools@gmail.com"
				);

		return array_merge($config, self::getConfig());;
	}

}
