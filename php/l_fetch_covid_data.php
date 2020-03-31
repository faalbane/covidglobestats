<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Detroit');
$l_today_date = date("m-d-Y");
$l_yesterdate = date('m-d-Y', strtotime("yesterday"));

$l_gostatus = array();
$l_godata = array();

$l_url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/" . $l_yesterdate . ".csv";
$l_handle = curl_init($l_url);
curl_setopt($l_handle,  CURLOPT_RETURNTRANSFER, TRUE);

/* Get the HTML or whatever is linked in $url. */
$l_response = curl_exec($l_handle);

/* Check for 404 (file not found). */
$l_httpCode = curl_getinfo($l_handle, CURLINFO_HTTP_CODE);
if($l_httpCode == 404) {
	curl_close($l_handle);
    /* Handle 404 here. */
	//try l_yesterdate data
	$l_url = "https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/" . $l_today_date . ".csv";
	$l_handle = curl_init($l_url);
	curl_setopt($l_handle,  CURLOPT_RETURNTRANSFER, TRUE);
	
	/* Get the HTML or whatever is linked in $url. */
	$l_response = curl_exec($l_handle);
	
	/* Check for 404 (file not found). */
	$l_httpCode = curl_getinfo($l_handle, CURLINFO_HTTP_CODE);
	if($l_httpCode == 404) {
		curl_close($l_handle);
		/* Handle 404 here. */
		$l_gostatus[] = array("status" => "l_oops!");
		echo json_encode(array($l_status, $l_data));
	}else{
		curl_close($l_handle);
		//l_go
		//echo "lahh3";
		$l_data = file_get_contents("https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/" . $l_yesterdate . ".csv");
		$l_rows = explode("\n",$l_data);
		$l_s = array();
		foreach($l_rows as $l_row) {
			$l_s[] = str_getcsv($l_row);
		}
		//print_r($l_s);
		//l_process
		$l_gostatus[] = array("l_status" => "l_go!");
		$l_count = count($l_s);
		$l_i = 1;
		while($l_i < $l_count){
			if (isset($l_s[$l_i][3])) {
				$l_godata[] = array("l_uid" => $l_i, "l_country_region" => $l_s[$l_i][3], "l_last_update" => $l_s[$l_i][4], "l_lat" => $l_s[$l_i][5], "l_lon" => $l_s[$l_i][6], "l_confirmed" => $l_s[$l_i][7], "l_deaths" => $l_s[$l_i][8], "l_recover" => $l_s[$l_i][9], "l_active" => $l_s[$l_i][10], "l_combo_key" => $l_s[$l_i][11]);	
			}
			$l_i++;
		}
		echo json_encode(array($l_status, $l_data));
	}
}else{
	curl_close($l_handle);
	//l_go
	//echo "lahh3";
	$l_data = file_get_contents("https://raw.githubusercontent.com/CSSEGISandData/COVID-19/master/csse_covid_19_data/csse_covid_19_daily_reports/" . $l_yesterdate . ".csv");
	$l_rows = explode("\n",$l_data);
	$l_s = array();
	foreach($l_rows as $l_row) {
		$l_s[] = str_getcsv($l_row);
	}
	//print_r($l_s);
	//l_process
	$l_gostatus[] = array("l_status" => "l_go!");
	//echo $l_s[0][0]; //FIPS
	/*
		[0] => FIPS
        [1] => Admin2
        [2] => Province_State
        [3] => Country_Region
        [4] => Last_Update
        [5] => Lat
        [6] => Long_
        [7] => Confirmed
        [8] => Deaths
        [9] => Recovered
        [10] => Active
        [11] => Combined_Key
	*/
	//echo count($l_s);
	$l_count = count($l_s);
	$l_i = 1;
	while($l_i < $l_count){
		if (isset($l_s[$l_i][3])) {
			$l_godata[] = array("l_uid" => $l_i, "l_country_region" => $l_s[$l_i][3], "l_last_update" => $l_s[$l_i][4], "l_lat" => $l_s[$l_i][5], "l_lon" => $l_s[$l_i][6], "l_confirmed" => $l_s[$l_i][7], "l_deaths" => $l_s[$l_i][8], "l_recover" => $l_s[$l_i][9], "l_active" => $l_s[$l_i][10], "l_combo_key" => $l_s[$l_i][11]);	
		}
		$l_i++;
	}
	echo json_encode(array($l_gostatus, $l_godata));
	
}

?>