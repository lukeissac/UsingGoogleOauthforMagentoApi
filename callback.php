<?php
session_start();
require_once ("OAuth.php");
require_once ("config.php");

$key = 'gqhilnvdw6gxuq6cm78cb08mtqyir8uu';//'<your app's API key>';
$secret = 'ticcppzjwkn5rssqpx5gkfo2dnjdt4an';//'<your app's secret>';

$oauth_access_token_endpoint = 'http://localhost/magento7/oauth/token';

$base_url="http://localhost/magentoapitest/";

$token=$_REQUEST['oauth_token'];
$oauth_verifier=$_REQUEST['oauth_verifier'];
$token_secret=$_SESSION['oauthtokensecret'];


    $args = array();  
    $args["oauth_verifier"]=$oauth_verifier;
    
    $consumer = new OAuthConsumer($key, $secret, NULL); 
    $auth_token = new OAuthConsumer($token, $token_secret);
    $access_token_req = new OAuthRequest("GET", $oauth_access_token_endpoint);
    $access_token_req = $access_token_req->from_consumer_and_token($consumer,
                $auth_token, "GET", $oauth_access_token_endpoint, $args);

    $access_token_req->sign_request(new OAuthSignatureMethod_HMAC_SHA1(),$consumer,
                $auth_token);
    $after_access_request = dotheHttpRequest($access_token_req->to_url());
	  
    
    
    parse_str($after_access_request,$access_tokens);
    $access_token = new OAuthConsumer($access_tokens['oauth_token'], $access_tokens['oauth_token_secret']);
    
    var_dump($after_access_request);
	
	
	
        $streamkey_req = $access_token_req->from_consumer_and_token($consumer,
                $access_token, "GET", "http://localhost/magento7/api/rest/products");     /* we can replace here the end-points as per requirement */

	$streamkey_req->sign_request(new OAuthSignatureMethod_HMAC_SHA1(),$consumer,$access_token);

	$after_request = dotheHttpRequest($streamkey_req->to_url());

	var_dump($after_request);

?>
