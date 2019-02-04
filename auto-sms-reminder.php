<?php
	require_once "vendor/autoload.php";
	use Twilio\Rest\Client;

	$account_sid = "INSERT_TWILIO_ACCOUNT_ID";
	$auth_token = "INSERT_TWILIO_AUTH_TOKEN";

	$twilio_number = "INSERT_TWILIO_FROM_NUMBER";
	$to_number = "INSERT_TO_NUMBER";
	
	$_GET["group-number"] = "INSERT_GROUP_ID_NUMBER";
	$_GET["json"] = "";
	include("status-checker.php");
	
	$data = json_decode($json, 1);
	$client = new Client($account_sid, $auth_token);
	
	if($data["match"] == "true") {
		$message1 = "Match for ".$_GET["group-number"]."\n";
		$message1 .= "Week of: ".$data["metadata"]["week_of"]["string"]."\n";
		$message1 .= "Group: ".ucwords($data["match_info"]["group"])."\n";
		$message1 .= "Location: ".$data["match_info"]["location"]["long_name"]."\n";

		$client->messages->create(
		    $to_number,
		    array(
		        'from' => $twilio_number,
		        'body' => $message1
		    )
		);

		$message2 = $data["match_info"]["string"]."\n";
		
		$client->messages->create(
		    $to_number,
		    array(
		        'from' => $twilio_number,
		        'body' => $message2
		    )
		);
	} else {
		$message = "No match for ".$_GET["group-number"];

		$client->messages->create(
		    $to_number,
		    array(
		        'from' => $twilio_number,
		        'body' => $message
		    )
		);
	}
?>