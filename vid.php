<?

$camera = $_GET['cam'];
$year = $_GET['year'];
$month = $_GET['month'];
$day = $_GET['day'];
$time = $_GET['time'];

$urltothetime = $camera."/".$year."/".$month."/".$day."/".$time.".mp4";


?>
<html><head><meta name="viewport" content="width=device-width"></head><body style="margin: 0px;"><video controls="" autoplay="" name="media" id="vid"><source src="<?=$urltothetime ?>" type="video/mp4"></video>

<br><br>

<span style="margin:20px;font-size:30px;cursor:pointer;" onclick="document.getElementById('vid').playbackRate = 1;">&gt;</span>
<span style="margin:20px;font-size:30px;cursor:pointer;" onclick="document.getElementById('vid').playbackRate += 1;">&gt;&gt;</span>

</body></html>
<?
