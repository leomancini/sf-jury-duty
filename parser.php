<?php 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, "https://www.sfsuperiorcourt.org/divisions/jury-services/jury-reporting"); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    $html = curl_exec($ch); 
    curl_close($ch);     
	
	function clean_html($html) {
		$html = str_replace("\n", "", $html);
		$html = str_replace("\r", "", $html);
		$html = str_replace("\t", "", $html);
		$html = str_replace("> <", "><", $html);
		
		return $html;
	}
	
	$html = clean_html($html);
	$html = strip_tags($html);
	$html = strtolower($html);
		
	preg_match('/jury reporting instructions:(.*)print/', $html, $metadata);
	
	preg_match('/civic center courthouse:(.*)groups reporting:(.*)groups on standby:(.*)groups already reported:(.*)hall of justice:(.*)groups reporting:(.*)groups on standby:(.*)groups already reported:(.*)parking and public transportation/', $html, $parsed_data);
	
	foreach($parsed_data as $parsed_data_key => $parsed_data_value) {
		$parsed_data_value_clean = trim($parsed_data_value);
		$parsed_data_value_clean = str_replace("&nbsp;", "", $parsed_data_value_clean);
		$parsed_data[$parsed_data_key] = $parsed_data_value_clean;
	}
		
	$data = Array(
		"metadata" => Array(
			"date" => $metadata[1]
		),
		"locations" => Array(
			"civic_center" => Array(
				"address" => $parsed_data[1],
				"groups" => Array(
					"reporting" => Array(
						"string" => $parsed_data[2]
					),
					"standby" => Array(
						"string" => $parsed_data[3]
					),
					"already_reported" => Array(
						"string" => $parsed_data[4]
					),
				)
			),
			"hall_of_justice" => Array(
				"address" => $parsed_data[5],
				"groups" => Array(
				"reporting" => Array(
					"string" => $parsed_data[6]
				),
				"standby" => Array(
					"string" => $parsed_data[7]
				),
				"already_reported" => Array(
					"string" => $parsed_data[8]
				),
				)
			)
		)
	);
	
	function extract_group_numbers($string) {
		global $html;
		global $data;
		
		$string_clean = str_replace($data["locations"]["civic_center"]["address"], "", $string);
		$string_clean = str_replace($data["locations"]["hall_of_justice"]["address"], "", $string_clean);
		$string_clean = preg_split('/on (.*), (.*) (\d){1,}, (\d){4}/', $string_clean)[0];

		preg_match('/juror hotlineif you have questions, call us at ([2-9]\d{2}-\d{3}-\d{4}), /', $html, $hotline_number);		
		$string_clean = str_replace($hotline_number[1], "", $string_clean);
		
		preg_match_all('/(\d){3}/', $string_clean, $groups);
		
		$groups[0] = array_map("trim", $groups[0]);
		
		return $groups[0];
	}
	
	foreach($data["locations"] as $location => $location_data) {
		foreach($data["locations"][$location]["groups"] as $group => $group_value) {
			$data["locations"][$location]["groups"][$group]["numbers"] = extract_group_numbers($data["locations"][$location]["groups"][$group]["string"]);
		}
	}	
	
	if(isset($_GET["json"])) {
		echo json_encode($data);
	} else {
		echo "<pre>";
		echo "<a href='?json'><h3>View as JSON</h3></a>";
		print_r($data);
		echo "</pre>";
	}
?>