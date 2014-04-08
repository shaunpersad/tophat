<?php
require_once 'config.php';

$sql = 'SELECT * FROM leaderboard ORDER BY `unformatted_time` ASC LIMIT 10';
$result = $db->query($sql);

if (mysql_num_rows($result)) {
	
	echo '<ol>';
	$count = 0;
	while ($record = mysql_fetch_assoc($result)) {
		$count++;
		
		
		$fullname = trim($record['name']);
		
		$explode = explode(' ', $fullname);
		
		$name = strtoupper($explode[0]);
		
		if ($count % 2) { ?>
			
            <li>
			<?php
		} else { ?>
			 <li class="bg">
			<?php
		}?>
        
            <span class="rank"><?=$count?></span>
            <span class="name"><?=$name?></span> 
            <span class="record"><?=$record['unformatted_time']?></span>         
        </li>
        <?php
	}
	
	echo '</ol>';
}