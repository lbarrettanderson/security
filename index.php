<?php

$cameras = ["cam1","cam2","cam3","cam4","cam5"];

$weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$monthNames = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");


foreach ($cameras as $camera) {
	echo "<br><br><a href='live.php?cam=".$camera."'>".$camera."</a><br>";
	for ($i = 0; $i < 7; $i++) {
 	   echo "<div style=\"display:inline-block;width:150px;border:1px solid black;padding:5px;background-color:#CCC;\">".$weekdays[$i]."</div>";
	}
	echo "<br>";
	$years = scandir($camera);
	$lastday = -1;
	foreach ($years as $year) {
		if ($year == "." || $year == "..") {
		   continue;
		}

		$months = scandir($camera."/".$year);
        	foreach ($months as $month) {
	        	if ($month == "." || $month == "..") {
			    continue;
			}

			$days = scandir($camera."/".$year."/".$month);
			$monthName = $monthNames[(int)$month];
	        	foreach ($days as $day) {
				    if ($day == "." || $day == "..") {
				           continue;
				    }
				    $dayofweek = date("N", strtotime($day." ".$monthName." ".$year));
				    if ($dayofweek == 7) $dayofweek = 0;
      	        	            for ($i = $lastday + 1; $i < $dayofweek; $i++) {
				      	 echo "<div style=\"display:inline-block;width:150px;border:1px solid black;padding:5px;background-color:#eee;\">&nbsp;</div>";
				    }
				    $lastday = $dayofweek;
				    echo "<div style=\"display:inline-block;width:150px;border:1px solid black;padding:5px;background-color:#fff;\"><a href=\"day.php?cam=".$camera."&year=".$year."&month=".$month."&day=".$day."\">".$monthName." ".$day."</a></div>";
				    if ($dayofweek == 6) {
				       echo "<br>";
				    }
			}

		 }
	}

}

?>