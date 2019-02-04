<?php
	$_GET["array"] = "";
	include("parser.php");
	
	$output = Array(
		"match" => "false"
	);
	
	foreach($data["locations"] as $location => $location_data) {
		foreach($location_data["groups"] as $group => $group_data) {			
			if(in_array($_GET["group-number"], $group_data["numbers"])) {
				if(isset($_GET["week-of"])) {
					 if(strtotime($_GET["week-of"]) == $data["metadata"]["week_of"]["strtotime"]) {
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
		 				$output["metadata"] = $data["metadata"];
					 } else {
 		 				$output["match"] = "false";
					 }
				} else {
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
					$output["metadata"] = $data["metadata"];
				}
			}
		}
	}
	
	if(isset($_GET["json"])) {
		$json = json_encode($output);
		echo $json;
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