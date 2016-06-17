<?php

include 'MultiPermute.php';

function createRoulette($fieldsCount, $chipCount){
    return array_fill(0, $chipCount, 1) + array_fill($chipCount, $fieldsCount-$chipCount, 0);
}

function calculatePermutations($fieldsCount, $chipCount){
    return gmp_strval(
        gmp_div(gmp_fact($fieldsCount), gmp_mul(gmp_fact($chipCount), gmp_fact($fieldsCount - $chipCount)))
    );
}



$options = getopt('', ['fieldsCount:', 'chipCount:']);

if(!isset($options['fieldsCount'])){
    die("--fieldsCount обязательный параметр\n");
}

if(!isset($options['chipCount'])){
    die("--chipCount обязательный параметр\n");
}

$fieldsCount = (int)$options['fieldsCount'];
$chipCount = (int)$options['chipCount'];

if($chipCount > $fieldsCount){
    die("Количество фишек не может быть больше чем количество ячеек\n");
}

$roulette = createRoulette($fieldsCount, $chipCount);

$permutationsCount = calculatePermutations($fieldsCount, $chipCount);

$fp = fopen('casino.txt', 'w');

if($permutationsCount < 10){
    fwrite($fp, 'Менее 10 вариантов');
}else{
    fwrite($fp, $permutationsCount."\n");

    $fileWriteCallback = function($permutation) use($fp){
        fwrite($fp, str_replace([0,1],['.','$'],implode('',$permutation))."\n");
    };

    MultiPermute::generate($roulette, $fileWriteCallback);
}