<?php
session_start();
require_once ("OAuth.php");
require_once ("config.php");

$key = 'gqhilnvdw6gxuq6cm78cb08mtqyir8uu';//'<your app's API key>';
$secret = 'ticcppzjwkn5rssqpx5gkfo2dnjdt4an';//'<your app's secret>';

$url = "http://localhost/magento7/oauth/initiate";
$request_token_endpoint = 'http://localhost/magento7/oauth/initiate';
$authorize_endpoint = 'http://localhost/magento7/admin/oauth_authorize';
$base_url="http://localhost/magentoapitest/";
      
    $args = array();  
    $args["oauth_callback"] = "http://localhost/magentoapitest/callback.php";  
    $consumer = new OAuthConsumer($key, $secret);  
    $request = OAuthRequest::from_consumer_and_token($consumer, NULL,"GET", $url, $args);  
    $request->sign_request(new OAuthSignatureMethod_HMAC_SHA1(), $consumer, NULL);  
    $url = sprintf("%s?%s", $url, OAuthUtil::build_http_query($args));  
     
    $result=doHttpRequest($request, $url);

	parse_str ($result,$tokens);

	$oauth_token = $tokens['oauth_token'];
	$oauth_token_secret = $tokens['oauth_token_secret'];
	$_SESSION['oauthtokensecret']=$oauth_token_secret;

	$callback_url = "$base_url/callback.php?key=$key&token=$oauth_token&token_secret=$oauth_token_secret&endpoint="
		            . urlencode($authorize_endpoint);

	$auth_url = $authorize_endpoint . "?oauth_token=$oauth_token&oauth_callback=".urlencode($callback_url);

	//Forward us to justin.tv for auth
	Header("Location: $auth_url");  
?>  

