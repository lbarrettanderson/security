<?

$camera = $_GET['cam'];
$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];

$urltotheday = $camera."/".$year."/".$month."/".$day;


?>

<html>
<head>

<script type="text/javascript">

var showingVid = {};


function mouseover(id) {
	 //console.log("over "+id);
	 //if (document.getElementById('a_'+id).innerHTML.startsWith("<video")) return;
	 if (showingVid[id]) return;
	 //console.log("passed");
	 showingVid[id] = 1;
	 document.getElementById('a_'+id).innerHTML = '<video autoplay height="180" width="320"><source src="<?=$urltotheday."/" ?>'+ id +'_100x.mp4" type="video/mp4">SADNESS</video><br>' + id;
}

function mouseout(id) {
	 //console.log("out "+id);
	 //if (!document.getElementById('a_'+id).innerHTML.startsWith("<video")) return;
	 if (!showingVid[id]) return;
	 //console.log("passed");
	 showingVid[id] = 0;
	 document.getElementById('a_'+id).innerHTML = '<img width="320" height="180" src="<?=$urltotheday ?>/' + id + '_th.jpg" /><br>' + id;
}


</script>

</head>
<body>
<?



$times = scandir($camera."/".$year."/".$month."/".$day);
foreach ($times as $time) {
    $isMp4 = preg_match('/(\d\d\d\d).mp4/', $time, $matches);
    if ($time == "." || $time == ".." || !$isMp4) {
           continue;
    }
    $vidUrl = "vid.php?day=".$day."&cam=".$camera."&year=".$year."&month=".$month."&time=".$matches[1];
?>
<div id="t_<?=$matches[1] ?>" style="display:inline-block;width:320px;margin-bottom:25px;margin-right:10px;" onmouseenter="mouseover('<?=$matches[1] ?>');" onmouseleave="mouseout('<?=$matches[1] ?>');">


<!--<a id="a_<?=$matches[1] ?>" href="<?=$urltotheday."/".$time  ?>"><img width="320" height="180" src="<?=$urltotheday."/".$matches[1]."_th.jpg" ?>" /><br><?=$matches[1] ?> -->
<a id="a_<?=$matches[1] ?>" href="<?=$vidUrl ?>"><img width="320" height="180" src="<?=$urltotheday."/".$matches[1]."_th.jpg" ?>" /><br><?=$matches[1] ?>
</a>


</div>
<?


}

?>

</body>
</html>