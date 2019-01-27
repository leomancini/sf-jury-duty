<pre><?php 
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

	echo $html;
?>