<?php

require_once __DIR__."/settings.php";

define("VERBOSE", in_array('-v', $argv) ? true : false);
//define("VERBOSE", true);

function exitWithMessage($msg, $state="0") {
	if(VERBOSE) {
		fwrite(STDERR, "$msg\n");
	}
	die((string) $state);
}

function dateIsAboveThreshold(DateTime $time, $threshold=0) {
	$now = new DateTime();
	if ($threshold) {
		$thresholdTime = clone($time);
		$prefix = $threshold > 0 ? "+" : "";
		$thresholdTime->modify($prefix . $threshold . " seconds");
		return $thresholdTime > $now;
	}
	else {
		return false;
	}
}

if (!file_exists(DATA_FILE)) {
	exitWithMessage("Data file does not exist.");
}

$data = json_decode(file_get_contents(DATA_FILE));
if (!$data) {
	exitWithMessage("Empty JSON data.");	
}

// If we have no enter data, assume absence
if (empty($data->enter) || empty($data->enter->date)) {
	exitWithMessage("No enter data.");
}

$lastEnter = new DateTime($data->enter->date);

// If last enter was pushed into the future by the threshold, assume absence
if (dateIsAboveThreshold($lastEnter, ENTER_THRESHOLD)) {
	exitWithMessage("Last enter is in the future.");
}

// If we have no exit data, assume presence
if (empty($data->exit) || empty($data->exit->date)) {
	die("1");
}

$lastExit = new DateTime($data->exit->date);

// If last exit is in the future, assume presence
if (dateIsAboveThreshold($lastExit, EXIT_THRESHOLD)) {
	exitWithMessage("Last exit is in the future.", "1");
}

// Check if last message was enter or exit
if ($lastExit > $lastEnter) {
	die("0");
}
else {
	die("1");
}