<?php

/**
 * REQUIREMENT:
 *
 *      Parse message board posts
 *
 * USAGE:
 *
 *      []$ php main.php < data/posts.csv 
 *
 * OUTPUT:
 *
 *      1. top_posts.csv will contain a list of top post id's, according to the rules below.
 *      2. other_posts.csv will contain a list of remaining post id's.
 *      3. daily_top_posts.csv will contain the single highest scoring top post of the day, based on likes.
 */
$time_start = microtime(true);

include_once dirname(__FILE__) . '/init.php';
$config = include_once ROOT . '/config.php';

// check if it's input file
if (isset($argv[1]) && is_file($argv[1]))
    $filename = $argv[1];
else
    echo 'Invalid input file. Usage: []$ php main.php /path/to/file' . PHP_EOL;

// configuarable output writer
$postWriter = new PostWriter($config['output_files']);

// if ($config['output_format'] == 'CSV') 
$postWriter->setFormatter(new CSVFormatter);

$processer = new PostProcesser($filename, $postWriter);
$processer->run();

$time_end = microtime(true);
echo "PROCESS TIME: " . number_format($time_end - $time_start, 4) . PHP_EOL;
echo "MEMORY USAGED: " . memory_get_usage() . 'KB' . PHP_EOL;

