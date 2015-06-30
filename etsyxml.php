<?php

// Current URL of file
$domain = $_SERVER['HTTP_HOST'];
$path = $_SERVER['SCRIPT_NAME'];

// Defines API Key, username and results limit //
$api_key = "apikey";
$username = "etsyusername";

// Defines Etsy's sandbox listings URL with previous variables //
$url = "https://openapi.etsy.com/v2/public/shops/" . $username . "/listings/active?includes=Images&api_key=" . $api_key;

// From Etsy's development section, uses the sandbox URL to communicate with Etsy's server //
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_body = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if (intval($status) != 200) throw new Exception("HTTP $status\n$response_body");

// Show JSON data available
// print $response_body;

// Converts the JSON string from Etsy into PHP
$response = json_decode($response_body);
// Finds the total number of results
$count = $response->count;

// Print XML beginning
print '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
    <title>Etsy Shop for' . $username . '</title>
    <link>http://' . $domain . $path . '</link>
    <description>Complete listings from ' . $username . '</description>
	<language>en-us</language>
	<atom:link href="' . $domain . $path . '" rel="self" type="application/rss+xml" />';

// Everytime the total results is less than the integer, loop
for ($i = 0; $i<$count; $i++) {

	// Each row
	$listing = $response->results[$i];

	// Convert likely currency to symbol
	if ($listing->currency_code == 'USD') {
		$currency_code = '$';
	} elseif ($listing->currency_code == 'GBP') {
		$currency_code = '£';
	}

	// Convert tags array to string with comma seperation, replace _ with a space and capitalise the first letters
	$tags = implode (", ", $listing->tags);
	$tags = str_replace("_", " ", $tags);
	$tags = ucwords($tags);

	// Convert tags array to string with comma seperation, replace _ with a space and capitalise the first letters
	$categories = implode (", ", $listing->category_path);
	$categories = str_replace("_", " ", $categories);

	// Convert materials to string, replace _ with a space and capitalise the first letters
	$material = implode("", $listing->materials);
	$material = str_replace("_", " ", $material);
	$material = ucwords($material);

	// Convert style to string, replace _ with a space and capitalise the first letters
	$styles = implode (", ", $listing->style);
	$styles = str_replace("_", " ", $styles);
	$styles = ucwords($styles);

	// Convert style to string, replace _ with a space and capitalise the first letters
	$made = str_replace("_", " ", $listing->when_made);
	$made = ucwords($made);

	// Change baby_boys and baby_girls to Boys or Girls
	if ($listing->recipient == 'baby_boys' OR $listing->recipient == 'boys') {
		$sex = 'Boy';
	} elseif ($listing->recipient == 'baby_girls' OR $listing->recipient == 'girls') {
		$sex = 'Girl';
	} else {
		$sex = 'Unisex';
	}

	// Print information
	print '
		<item>
			<title>' . $listing->title . '</title>
			<description>' . $listing->description . '</description>
			<date>' . $listing->creation_tsz . '</date>
			<enddate>' . $listing->ending_tsz .'</enddate>
			<active>' . $listing->state .'</active>
			<price>' . $currency_code . $listing->price . '</price>
			<quantity>' . $listing->quantity . '</quantity>
			<tags>' . $tags . '</tags>
			<categories>' . $categories . '</categories>
			<material>'  . $material . '</material>
			<sex>' . $sex . '</sex>
			<style>' . $styles . '</style>
			<made>' . $made . '</made>
			<url>http://www.etsy.com/listing/' . $listing->listing_id . '</url>
			<images>';

	// Count images in array and print Images
	$imagecount = count($listing->Images);

	foreach ($listing->Images as $images) {
		if ($imagecount != $images->rank) {
			print $images->url_fullxfull . ',';
		} else {
			print $images->url_fullxfull;
		}
	}

	print '</images>
		</item>';
}

print '
	</channel>
</rss>';

?>
