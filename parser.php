<?php 
	include("scraper.php");
	$html = scrape_url_and_clean_html("https://www.sfsuperiorcourt.org/divisions/jury-services/jury-reporting");
		
	preg_match('/jury reporting instructions:(.*)print/i', $html, $metadata);
	
	preg_match('/civic center courthouse:(.*)groups reporting:(.*)groups on standby:(.*)groups already reported:(.*)hall of justice:(.*)groups reporting:(.*)groups on standby:(.*)groups already reported:(.*)parking and public transportation/i', $html, $parsed_data);
	
	foreach($parsed_data as $parsed_data_key => $parsed_data_value) {
		$parsed_data_value_clean = trim($parsed_data_value);
		$parsed_data_value_clean = str_replace("&nbsp;", "", $parsed_data_value_clean);
		$parsed_data[$parsed_data_key] = $parsed_data_value_clean;
	}
	
	function clean_string($string) {
		$clean_string = ucfirst($string);
		$clean_string = str_replace("Mcallister", "McAllister", $clean_string);
		$clean_string = str_replace("And", "and", $clean_string);
		$clean_string = str_replace("revisit", ". Revisit", $clean_string);
		$clean_string = str_replace(" .", ".", $clean_string);
		$clean_string = str_replace(".No groups", ". No groups", $clean_string);
		
		$clean_string = str_replace(",", ", [[comma spacer]]", $clean_string);
		$clean_string = str_replace(", [[comma spacer]]", ", ", $clean_string);
		$clean_string = str_replace(",  ", ", ", $clean_string);
		
		return $clean_string;
	}
		
	$week_of_string = trim(str_replace("Week of", "", $metadata[1]));
	
	$data = Array(
		"metadata" => Array(
			"week_of" => Array(
				"string" => $week_of_string,
				"strtotime" => strtotime($week_of_string),
				"date_reformatted" => Array(
					"month" => date("m", strtotime($week_of_string)),
					"day" => date("d", strtotime($week_of_string)),
					"year" => date("Y", strtotime($week_of_string))
				)
			)
		),
		"locations" => Array(
			"civic_center" => Array(
				"long_name" => "Civic Center",
				"address" => clean_string(ucwords(strtolower($parsed_data[1]))),
				"groups" => Array(
					"reporting" => Array(
						"string" => clean_string($parsed_data[2])
					),
					"standby" => Array(
						"string" => clean_string($parsed_data[3])
					),
					"already_reported" => Array(
						"string" => clean_string($parsed_data[4])
					)
				)
			),
			"hall_of_justice" => Array(
				"long_name" => "Hall of Justice",
				"address" => clean_string(ucwords($parsed_data[5])),
				"groups" => Array(
					"reporting" => Array(
						"string" => clean_string($parsed_data[6])
					),
					"standby" => Array(
						"string" => clean_string($parsed_data[7])
					),
					"already_reported" => Array(
						"string" => clean_string($parsed_data[8])
					)
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
	
	if(!isset($_GET["array"])) {
		if(isset($_GET["json"])) {
			echo json_encode($data);
		} else {
			echo "<pre>";
			echo "<a href='?json'><h3>View as JSON</h3></a>";
			print_r($data);
			echo "</pre>";
		}
	}
?>