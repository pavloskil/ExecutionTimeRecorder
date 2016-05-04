<?php
/*
 * Note: Example for demostrate ExecutionTimeRecorder class
 *
 */
require 'ExecutionTimeRecorder.php';

// Example function
function fx() {
	for ($i=1; $i>=10000; $i++) {
		$out += (sqrt(pi*$i))*(pow(pi, $i));
	}
	return;
}

// set timer objects
$t1 = new ExecutionTimeRecorder();
$t2 = new ExecutionTimeRecorder();


/*
 * Let's calculate the time it takes to run fx() plus a time delay
 * for demostration purposes.
 */

// Timer t1 has to calculate multiple code blocks
// Start timer t1 #0
$t1->start();

//code block
usleep(400000); // 400ms delay
fx();

// End timer t1 #0
$t1->stop();


// Timer t1 #1
$t1->start();
sleep(1); // 1 sec delay
fx();
$t1->stop();


// Timer t1 #2
$t1->start();
usleep(500000); // 500ms delay
fx();
$t1->stop();


// Timer t1 #3
$t1->start();
fx();
$t1->stop();

// Second instance of the class
// Timer t2 #0
$t2->start();
usleep(600000); // 600ms delay
fx();
$t2->stop();


// Print out the results
echo "<h3>Test results</h3>";
echo "Timer t1 #0 <br>{$t1->get(0)} seconds<br><br>";
echo "Timer t1 #1 <br>{$t1->get(1)} seconds<br><br>";
echo "Timer t1 #2 <br>{$t1->get(2)} seconds<br><br>";
echo "<b>All t1 timers</b><br>{$t1->getAll()} seconds<br><br>";
echo "Timer t2 #0 <br>{$t2->get(0)} seconds<br><br>";
echo "<b>All t2 timers</b><br>{$t2->getAll()} seconds<br><br>";

?>