<?php
/**
 * Calculates the execution time of a script block or entire page.
 *
 * Create a timer:
 * Enclose blocks to start() and stop() methods to calculate execution time.
 *
 * Multiple Instances:
 * You can use many instances of the class (timers) on a single page.
 *
 * Multiple blocks:
 * You can test multiple blocks of the same object. Just enclose each block
 * to start() and stop() methods.
 * reset() method reset timers queue.
 * getAll() method summarize all object's timers and get($timer) method
 * outputs an individual timer's calculation.
 *
 * @author Pavlos Kilitsos <pavlos@kilitsos.com>
 */
class ExecutionTimeRecorder
{

	// command constants
	const START = 'start';
	const STOP = 'end';


	/**
	 * Stores current state of the timer
	 *
	 * @var boolean
	 */
	private $running = false;


	/**
	 * Contains the queue of times
	 *
	 * @var array
	 */
	private $queue = array();


	/**
	 * Start the timer
	 *
	 * @return void
	 */
	public function start() {
		// push current time
		$this->pushTime(self::START);
	}


	/**
	 * Stop the timer
	 *
	 * @return void
	 */
	public function stop() {
		// push current time
		$this->pushTime(self::STOP);
	}


	/**
	 * Reset contents of the queue
	 *
	 * @return void
	 */
	public function reset() {
		// reset the queue
		$this->queue = array();
	}


	/**
	 * Add a time entry to the queue
	 *
	 * @param string $cmd Command to push
	 * @return void
	 */
	private function pushTime($cmd) {
		// capture the time as early in the function as possible
		$mt = microtime(true);

		// set current running state depending on the command
		if ($cmd == self::START) {
			// check if the timer has already been started
			if ($this->running === true) {
				trigger_error('Timer has already been started', E_USER_NOTICE);
				return;
			}

			// set current state
			$this->running = true;

		} else if ($cmd == self::STOP) {
			// check if the timer is already stopped
			if ($this->running === false) {
				trigger_error('Timer has already been stopped/paused or has not yet been started', E_USER_NOTICE);
				return;
			}

			// set current state
			$this->running = false;

		} else {
			// fail execution of the script
			trigger_error('Invalid command specified', E_USER_ERROR);
			return;
		}

		// recapture the time as close to the end of the function as possible (if state changed again)
		if ($cmd === self::START) {
			$mt = microtime(true);
		}

		// create the array
		$time = array(
			$cmd => $mt,
		);

		// add a time entry depending on the command
		if ($cmd == self::START) {
			array_push($this->queue, $time);

		} else if ($cmd == self::STOP) {
			$count = count($this->queue);
			$array =& $this->queue[$count - 1];
			$array = array_merge($array, $time);
		}

	}


	/**
	 * Get execution time for a specific timer
	 *
	 * @param int $timer Timer to display
	 * @return float
	 */
	public function get($timer) {
		// stop timer if it is still running
		if ($this->running === true) {
			trigger_error('Forcing timer to stop', E_USER_NOTICE);
			$this->stop();
		}

		// sanitize input
		$timer = (int) filter_var($timer, FILTER_SANITIZE_NUMBER_INT);

		// get the selected time entry
		$time = $this->queue[$timer];

		// stop executing if time is NULL
		if (is_null($time)) {
			trigger_error("Timer $timer does not exist", E_USER_NOTICE);
			exit();
		}

		// start and end times
		$start = $time[self::START];
		$end = $time[self::STOP];

		// calculate difference between start and end values
		$diff = $end - $start;

		return round($diff, 6);

	}


	/**
	 * Get all timers total time of execution
	 *
	 * @return float
	 */
	public function getAll() {
		// stop timer if it is still running
		if ($this->running === true) {
			trigger_error('Forcing timer to stop', E_USER_NOTICE);
			$this->stop();
		}

		// loop through each time entry (timer)
		foreach ($this->queue as $time) {
			// get start and end values
			$start = $time[self::START];
			$end = $time[self::STOP];

			// calculate difference between start and end values
			$diff += $end - $start;
		}

		return round($diff, 6);
	}

}