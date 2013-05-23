<?php
function doHttpRequest($request, $url)
{
$ch = curl_init();

  $headers = array($request->to_header());  
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);  
    $rsp = curl_exec($ch); 

// close cURL resource, and free up system resources
curl_close($ch);

return $rsp;
} 

function dotheHttpRequest($urlreq)
{
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, "$urlreq");
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

// grab URL and pass it to the browser
$request_result = curl_exec($ch);

// close cURL resource, and free up system resources
curl_close($ch);

return $request_result;
}


?>
