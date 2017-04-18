<?

$cameras = ["cam1","cam2","cam3"];

echo "hello world<br>";
$spc = "&nbsp;";

foreach ($cameras as $camera) {
	echo $camera."<br>";
	$years = scandir($camera);
	foreach ($years as $year) {
		if ($year == "." || $year == "..") {
		   continue;
		}
		echo $spc.$spc.$year."<br>";

		$months = scandir($camera."/".$year);
        	foreach ($months as $month) {
	        	if ($month == "." || $month == "..") {
			    continue;
			}
			echo $spc.$spc.$spc.$spc.$month."<br>";


			$days = scandir($camera."/".$year."/".$month);
	        	foreach ($days as $day) {
				    if ($day == "." || $day == "..") {
				           continue;
				    }
				    echo $spc.$spc.$spc.$spc.$spc.$spc."<a href=\"day.php?cam=".$camera."&year=".$year."&month=".$month."&day=".$day."\">".$day."</a><br>";
			}

		 }
	}

}

?>