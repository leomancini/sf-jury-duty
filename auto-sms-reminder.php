<?php
	include("secrets.php");
	
	require_once "vendor/autoload.php";
	use Twilio\Rest\Client;
	
	$_GET["group-number"] = $group_number;
	$_GET["json"] = "";
	include("status-checker.php");
	
	$data = json_decode($json, 1);
	$client = new Client($twilio_account_sid, $twilio_auth_token);
	
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