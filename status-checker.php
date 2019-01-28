<?php
	$_GET["array"] = "";
	include("parser.php");
	
	$output = Array(
		"match" => "false"
	);
	
	foreach($data["locations"] as $location => $location_data) {
		foreach($location_data["groups"] as $group => $group_data) {			
			if(in_array($_GET["group-number"], $group_data["numbers"])) {
				$output["match"] = "true";
				$output["match_info"] = Array(
					"group" => $group,
					"location" => Array(
						"id" => $location,
						"long_name" => $location_data["long_name"],
						"address" => $location_data["address"]
					),
					"string" => $group_data["string"]
				);
			}
		}
	}
	
	if(isset($_GET["json"])) {
		echo json_encode($output);
	} else {
		echo "<pre>";
		if(isset($_GET["group-number"])) {
			echo "<a href='//".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."&json'><h3>View as JSON</h3></a>";
		} else {
			echo "<a href='?json'><h3>View as JSON</h3></a>";
		}
		print_r($output);
		echo "</pre>";
	}
?>