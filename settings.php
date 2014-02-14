<?php
/**
 * This is the settings file both for the webhook and the command line utility.
 */

// File name of the data file
define("DATA_FILE", __DIR__."/data.json");

// Number of seconds that must pass from the last "exit" notice until the state is "present" 
define("ENTER_THRESHOLD", 0);
// Number of seconds that must from the last "enter" notice until the state is "absent" 
// Use this if you have an iBeacon where the signal is lost and recovered regularly
define("EXIT_THRESHOLD", 300); // 10 Minutes
