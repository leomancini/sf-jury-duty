<?php
	function scrape_url($url) {
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		$data = curl_exec($curl); 
		curl_close($curl);     

		return $data;
	}

	function clean_html($html) {
		$html = str_replace("\n", "", $html);
		$html = str_replace("\r", "", $html);
		$html = str_replace("\t", "", $html);
		$html = str_replace("> <", "><", $html);
		$html = strip_tags($html);
		// $html = strtolower($html);
		
		return $html;
	}
	
	function scrape_url_and_clean_html($url) {
		$html = scrape_url($url);
		$clean_html = clean_html($html);
		
		return $clean_html;
	}
	
	if(isset($_GET["debug"])) {
		echo scrape_url_and_clean_html("https://www.sfsuperiorcourt.org/divisions/jury-services/jury-reporting");
	}
?>