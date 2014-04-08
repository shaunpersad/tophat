<?php
require_once 'classes/EasyDB.php';

$db_config = array( 'host' => 'mysql.shaunpersad.com',
				 'user' => 'sp_tophat_user',
				 'password' => 'atlantic271',
				 'dbname' => 'dev_tophat');

/*
$db_config = array( 'host' => 'localhost',
				 'user' => 'clue_user',
				 'password' => 'convo123',
				 'dbname' => 'buffets_clue');
*/
$db = new EasyDB($db_config);