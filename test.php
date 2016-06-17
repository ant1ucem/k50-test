<?php

include 'MultiPermute.php';

function testHandler($file, $line, $code, $desc = null){
    echo "Assertion failed at $file:$line: $code";
    if ($desc) {
        echo ": $desc";
    }
    echo "\n";
}

assert_options(ASSERT_CALLBACK, 'testHandler');

$count = 0;

$echoCallback = function($permutation) use(&$count){
    $count++;
    echo(str_pad($count, 2).': '. implode(',',$permutation)."\n");
};


ob_start();
MultiPermute::generate([1,1,1,0,0,0], $echoCallback);
$output = ob_get_contents();
ob_end_clean();

$expected = '1 : 1,1,1,0,0,0
2 : 0,1,1,1,0,0
3 : 1,0,1,1,0,0
4 : 1,1,0,1,0,0
5 : 0,1,1,0,1,0
6 : 1,0,1,0,1,0
7 : 0,1,0,1,1,0
8 : 0,0,1,1,1,0
9 : 1,0,0,1,1,0
10: 1,1,0,0,1,0
11: 0,1,1,0,0,1
12: 1,0,1,0,0,1
13: 0,1,0,1,0,1
14: 0,0,1,1,0,1
15: 1,0,0,1,0,1
16: 0,1,0,0,1,1
17: 0,0,1,0,1,1
18: 0,0,0,1,1,1
19: 1,0,0,0,1,1
20: 1,1,0,0,0,1
';

$ok = assert($expected == $output, 'Something wrong with MultiPermute');

if($ok){
    echo "Test passed\n";
}