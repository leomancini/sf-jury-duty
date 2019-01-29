<?php
	require_once "vendor/autoload.php";
	use Twilio\TwiML\MessagingResponse;

	// Set the content-type to XML to send back TwiML from the PHP Helper Library
	header("content-type: text/xml");

	$response = new MessagingResponse();
	
	$incoming = strtolower($_REQUEST['Body']);
	
	if($incoming == "i have jury duty") {
		$response_body = "Ok, what week?";
	} else {
		$response_body = "Sorry, I don't understand";
	}
	
	$response->message(
		$response_body
	);

	echo $response;