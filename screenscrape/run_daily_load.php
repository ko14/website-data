<?php

//include files
include 'load_announcements.php';
include 'load_stocks.php';
include 'load_prices.php';
include 'load_streak.php';
include 'data_output.php';

$conn=mysql_connect();
if (!$conn) 
{die('Could not connect: ' . mysql_error());}
if (!mysql_select_db('stocks'))
{die('Could not select database: ' . mysql_error());}

//functions in include files
run_load_announcements($conn);
run_load_stocks($conn);
run_load_prices($conn);
run_load_streak($conn);
run_data_output($conn);

?>
