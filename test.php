<?
require_once ("OAuth.php");
require_once ("config.php");

$key = 'gqhilnvdw6gxuq6cm78cb08mtqyir8uu';//'<your app's API key>';
$secret = 'ticcppzjwkn5rssqpx5gkfo2dnjdt4an';//'<your app's secret>';

$base_url = "http://localhost/magentoapitest/test.php";
$request_token_endpoint = 'http://localhost/magento7/oauth/token';
$authorize_endpoint = 'http://localhost/magento7/admin/oAuth_authorize';

$test_consumer = new OAuthConsumer($key, $secret, NULL);

//prepare to get request token

$sig_method = new OAuthSignatureMethod_HMAC_SHA1();
$parsed = parse_url($request_token_endpoint);
$params = array(callback => $base_url);
parse_str($parsed['query'], $params);

$req_req = OAuthRequest::from_consumer_and_token($test_consumer, NULL, "GET", $request_token_endpoint, $params);
$req_req->sign_request($sig_method, $test_consumer, NULL);

$req_token = doHttpRequest ($req_req->to_url());

//assuming the req token fetch was a success, we should have
//oauth_token and oauth_token_secret

parse_str ($req_token,$tokens);

$oauth_token = $tokens['oauth_token'];
$oauth_token_secret = $tokens['oauth_token_secret'];

$callback_url = "$base_url/callback.php?key=$key&token=$oauth_token&token_secret=$oauth_token_secret&endpoint="
                    . urlencode($authorize_endpoint);

$auth_url = $authorize_endpoint . "?oauth_token=$oauth_token&oauth_callback=".urlencode($callback_url);

//Forward us to justin.tv for auth
Header("Location: $auth_url");

?>
