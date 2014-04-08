<?php
require_once 'config.php';

if (!empty($_POST['name']) && !empty($_POST['time'])) {

	$name = $_POST['name'];
	$time = $_POST['time'];
	
	$insert = array(
				'name' => $name, 
				'unformatted_time' => $time,
				'time' =>  date( 'H:i:s', strtotime($time.':00 am'))
			);
			
	$db->insert('leaderboard', $insert);			
}
include 'get-leaderboard.php';