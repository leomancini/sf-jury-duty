<?php
	require_once "vendor/autoload.php";
	use Twilio\TwiML\MessagingResponse;
	header("content-type: text/xml");

	$incoming = strtolower($_REQUEST['Body']);
	
	if($incoming == "i have jury duty") {
		$response_body = "Ok, what week?";
	} else {
		$response_body = "Sorry, I don't understand";
	}

	$response = new MessagingResponse();
	
	$response->message(
		$response_body
	);

	echo $response;
?>