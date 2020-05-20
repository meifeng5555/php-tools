<?php

// Helpers
function trace($msg, bool $exit = false)
{
    $time = date("Y-m-d H:i:s");
    if (is_array($msg)
        || is_object($msg)) {
        print_r($msg);
    } else {

        echo "[{$time}]: {$msg}" . PHP_EOL;
    }

    !$exit ?: exit(0);
}
function millisecond(): int
{
    return intval(microtime(true) * 1000);
}

// Duplicate Test
trace('1-100W数字数组存储');
$m1 = memory_get_usage();
$s1 = millisecond();
$arr = [];
for ($i = 1; $i <= 1000000; $i++) {
    $arr[] = $i;
}
$s2 = millisecond();
$m2 = memory_get_usage();
trace("Array memory used: ". ($m2 - $m1). "bytes time used: ". ($s2 - $s1). "ms");

trace('1-100位图存储');
require './Duplicate.php';
$m1 = memory_get_usage();
$s1 = millisecond();
$duplicate = new Duplicate();
for ($i = 1; $i <= 1000000; $i++) {
    $duplicate->add($i);
}
$s2 = millisecond();
$m2 = memory_get_usage();
trace("BitArray memory used: ". ($m2 - $m1). "bytes time used: ". ($s2 - $s1). "ms");

trace('1是否存在'. ($duplicate->exist(1) ? '是':'否'));
trace('15635是否存在'. ($duplicate->exist(15635) ? '是':'否'));
trace('10000001是否存在'. ($duplicate->exist(10000001) ? '是':'否'));
trace('999999999是否存在'. ($duplicate->exist(999999999) ? '是':'否'));
