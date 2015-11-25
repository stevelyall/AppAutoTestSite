<?php
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");

require_once("model.php");

if (isFlagSet('script_running')) {
	// script is already running
	echo "data: waiting\n";
} else if (!isFlagSet('script_running') && !isFlagSet('results_ready')) {
	echo "data: run\nn";
	runTests();
} else if (isFlagSet('results_ready')) {
	clearFlag('results_ready');
	echo "data: result ready\n";
}

function runTests()
{
	// TODO get script location
	// TODO call script
}

echo "\n";
ob_flush();
flush();