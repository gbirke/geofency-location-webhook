<?php
/**
 * This file is the endpoint for the GeoFency webhook.
 * It writes the submitted JSON to a data file
 *
 * @author Gabriel Birke <gb@birke-software.de>
 * @file
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/settings.php";

$request = Request::createFromGlobals();

function sendErrorResponse($msg, $status) {
	$response = new Response($msg, $status, array('Content-Type' => 'text/plain'));
	$response->send();
	exit;
}

// Check if data dir is writable
if (!is_writable(dirname(DATA_FILE))) {
	error_log(dirname(DATA_FILE)." is not writable");
	sendErrorResponse("Filesystem error, check logs for more info.", Response::HTTP_INTERNAL_SERVER_ERROR);
}

// Check if this is a POST request
if (!$request->isMethod('POST')) {
	sendErrorResponse("Not allowed.", Response::HTTP_METHOD_NOT_ALLOWED);
}

// get valid JSON from request
$content = $request->getContent();
$json = json_decode($content);
if (!$json) {
	sendErrorResponse("Request did not contain valid JSON.", Response::HTTP_BAD_REQUEST);
}

// Load old data
if (file_exists(DATA_FILE)) {
	$data = json_decode(file_get_contents(DATA_FILE));
	if (!$data) {
		$data = new stdClass;	
	}
}
else {
	$data = new stdClass;
}

// Store data as enter or exit
if ($json->entry) {
	$data->enter = $json;
}
else {
	$data->exit = $json;	
}

// Save data
if (!file_put_contents(DATA_FILE, json_encode($data))) {
	error_log(DATA_FILE." could not be written");
	sendErrorResponse("Filesystem error, check logs for more info.", Response::HTTP_INTERNAL_SERVER_ERROR);
}

$response = new Response("OK", Response::HTTP_OK, array('Content-Type' => 'text/plain'));
$response->send();


