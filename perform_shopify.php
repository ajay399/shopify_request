<?php


//call demo $data = performShopifyRequest($shop,$accessToken,"api/2019-10/metafields/{$metaid}",$params,"POST"); 

function performShopifyRequest($shop, $token, $resource, $params = array(), $method = 'GET') {
  $url = "https://{$shop}/admin/{$resource}.json";

  $curlOptions = array(
    CURLOPT_RETURNTRANSFER => TRUE
  );

  if ($method == 'GET') {
    if (!is_null($params)) {
      $url = $url . "?" . http_build_query($params);
    }
  } else {
    $curlOptions[CURLOPT_CUSTOMREQUEST] = $method;
  }

  $curlOptions[CURLOPT_URL] = $url;

  $requestHeaders = array(
    "X-Shopify-Access-Token: ${token}",
    "Accept: application/json"
  );

  if ($method == 'POST' || $method == 'PUT') {
    $requestHeaders[] = "Content-Type: application/json";

    if (!is_null($params)) {
      $curlOptions[CURLOPT_POSTFIELDS] = json_encode($params);
    }
  }

  $curlOptions[CURLOPT_HTTPHEADER] = $requestHeaders;

  $curl = curl_init();
  curl_setopt_array($curl, $curlOptions);
  $response = curl_exec($curl);
  curl_close($curl);

  return json_decode($response, TRUE);
}
 
$shop_details = performShopifyRequest($shop,$accessToken,"api/2021-07/shop",array(),"GET");
print_r($shop_details);


?>