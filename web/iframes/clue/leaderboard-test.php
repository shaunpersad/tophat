<?php
require_once 'config.php';


$name = 'test';
$time = '15:35';

$insert = array(
			'name' => $name, 
			'unformatted_time' => $time,
			'time' =>  date( 'H:i:s', strtotime($time.' am'))
		);
		
$db->insert('leaderboard', $insert);			
