# ExecutionTimeRecorder

## Synopsis

Calculates the execution time of a script block or entire page.


## Usage

Create a timer:
Enclose blocks to start() and stop() methods to calculate execution time.

Multiple Instances:
You can use many instances of the class (timers) on a single page.

Multiple blocks:
You can test multiple blocks of the same object. Just enclose each block to start() and stop() methods.
reset() method reset timers queue.
getAll() method summarize all object's timers and get($timer) methodoutputs an individual timer's calculation.

example.php contains a basic example.



## Installation

Just include the class to your project.



## License

MIT license