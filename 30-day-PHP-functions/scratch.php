<?php

$todos = [
    ['id' => 1, 'title' => 'Buy milk',   'done' => false, 'due' => '2026-06-20'],
    ['id' => 2, 'title' => 'Call Anna',  'done' => true,  'due' => '2026-06-16'],
    ['id' => 3, 'title' => 'Fix bug',    'done' => false, 'due' => '2026-06-18'],
];
// Day 1: array_filter - uses a callback function to filter elements of the array and returns a new array with the elements that pass the test implemented by the callback function.
function test_odd($var)
  {
  return($var['done'] === false);
  }

// print_r(array_filter($todos,"test_odd"));

// Day 2: array_map - uses a callback function to apply it to each element of the array and returns a new array with the modified elements.
function titles($var) {
    return $var['title'];
}

print_r(array_map("titles", $todos));

// Day 3: array_column - returns the values from a single column in the input array, identified by the column key.
print_r(array_column($todos, 'due'));

// in_array - checks if a value exists in an array and returns true if it does, false otherwise.
print_r(in_array( 'id', $todos[0], false));

// array_search - searches the array for a given value and returns the first corresponding key if successful, false otherwise.
print_r(array_search('Fix bug', array_column($todos, 'title'), false));

var_dump(print_r(false, true)); // print_r(false) returns ""
print_r(true);  // prints 1
print_r(false); // prints NOTHING

// array_keys - returns the keys of an array as a new array.
print_r(array_keys($todos[0]));

// array_values - returns the values of an array as a new array.
print_r(array_values($todos[0]));

// count() - counts all elements in an array or something in an object.
print_r(count($todos));

?>
