<?php

require_once("veiculos.php");

$countries = getCountries();

$phrase = "";

if(isset($_GET['phrase'])) {
	$phrase = $_GET['phrase'];
}

$dataType = "json";

if(isset($_GET['dataType'])) {
	$dataType = $_GET['dataType'];
}

$found_countries = array();

foreach ($countries as $key => $country) {
$placas =implode("", $country);
	if ($phrase == "" || stristr($placas, $phrase) != false) {
		array_push($found_countries	, $country);
        }
}


switch($dataType) {

	case "json":

		$json = '[';

		foreach($found_countries as $key => $country) {
			$json .= '{"name": "' . implode("", $country) . '"}';

			if ($country !== end($found_countries)) {
				$json .= ',';	
			}
		}

		$json .= ']';


		header('Content-Type: application/json');
		echo $json;

	break;

	

}


?>
