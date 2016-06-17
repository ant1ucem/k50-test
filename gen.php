<?php

include 'MultiPermute.php';

$fp = fopen('data.txt', 'w');
$fileWriteCallback = function($permutation) use($fp){
    fwrite($fp, str_replace(0,'.',implode('',$permutation))."\n");
};

//MultiPermute::generate([
//    1,1,1,1,
//    0,0,0,0,
//], $fileWriteCallback);

MultiPermute::generate([
    1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,
    0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0
], $fileWriteCallback);