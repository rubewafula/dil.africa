<?php


	$url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

	$consumer_key = "SVH66qBAtH6bKGibhZAWIBjxttt6MGTw";   
	$consumer_secret = "QCoK5cpdAPzsf7Bi";

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	$credentials = base64_encode($consumer_key.':'.$consumer_secret);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

	$curl_response = curl_exec($curl);
	$response = json_decode($curl_response, true);

	return $response["access_token"];
		
?>