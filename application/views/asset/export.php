<?php defined('BASEPATH') OR exit('No direct script access allowed');


$filename = "assets-export-$year.csv";
//Define the fields desired for output in this array
$fields = array(
		"product"=>"product",
		"name"=>"Name",
		"version"=>"Version",
		"type"=>"Type",
		"status"=>"Status",
		"serial_number"=>"Serial Number",
		"source"=>"How Acquired",
		"year_acquired"=>"Year Acquired",
		"purchase_price"=>"Purchase Price",
		"year_removed"=>"Year Removed",
		"sale_price"=>"Sale Price",
		"vendor"=>"Developer",
);
foreach (array_values($fields) as $value) {
	$header_values[] = $value;
}

$output = array(
		implode(",", $header_values)
);
foreach ($assets as $asset) {
	foreach (array_keys($fields) as $key) {
		$line[] = $asset->$key;
	}
	$output[] = "\"" . implode("\",\"", $line) . "\"";
	$line = NULL;
}

$data = implode("\n", $output);
force_download($filename, $data);