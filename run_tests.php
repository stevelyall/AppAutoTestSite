<?php
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");

require_once("model.php");

if (isFlagSet('script_running')) {
	// script is already running
	echo "data: waiting\n";
} else if (!isFlagSet('script_running') && !isFlagSet('results_ready')) {
	echo "data: run\n";
	runTests();
} else if (isFlagSet('results_ready')) {
	clearFlag('results_ready');
	echo "data: result ready\n";
}

function runTests()
{
	$script = getConfigProperty('script_location');
	$result = exec($script);
	echo "data: started" . $result . "\n"; // TODO don't send script output to client
}

echo "\n";
ob_flush();
flush();