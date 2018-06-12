<?php

$cameraname = $_GET['cam'];
$action = $_GET['a'];
$camera = "ramdisk/".$cameraname;


        $years = scandir($camera);
        $lastday = -1;
	$year = end($years);

        $months = scandir($camera."/".$year);
        $month = end($months);

        $days = scandir($camera."/".$year."/".$month);

        $day = end($days);


$times = scandir($camera."/".$year."/".$month."/".$day);
$lastOne = "";
$secondLast = "";
foreach ($times as $time) {
    $isSeg = preg_match('/(\d\d\d\d_seg_\d+).mp4/', $time, $matches);
    if (!$isSeg) continue;
    $secondLast = $lastOne;
    $lastOne = $matches[1];
}


$urltothetime = $camera."/".$year."/".$month."/".$day."/".$secondLast.".mp4";

if ($action == "last") {
   echo $urltothetime;
   exit;
}


?>


<html><head>
<meta name="viewport" content="width=device-width">

<script type="text/javascript">


var lastVid = '<?=$urltothetime ?>';
var whichVid = 0;
var vidChanged = 0;

function getNext() {

var xhr = new XMLHttpRequest();
xhr.open('get', 'live.php?cam=<?=$cameraname ?>&a=last');

xhr.onreadystatechange = function () {
    var DONE = 4;
    var OK = 200;
    if (xhr.readyState === DONE) {
        if (xhr.status === OK) {
	    if (lastVid != xhr.responseText) {
	        lastVid = xhr.responseText;
		document.getElementById('thesource'+((whichVid + 1) % 2)).setAttribute("src",lastVid);
		document.getElementById('vid'+((whichVid + 1) % 2)).load();
		vidChanged = new Date().valueOf();
	    }
	    setTimeout(getNext, 500);
        } else {
            //alert('Error: ' + xhr.status);
        }
    }
};

xhr.send(null);
}

function vidEnd() {
    var vidEnded = new Date().valueOf();
    //document.getElementById('thesource'+whichVid).setAttribute("src",lastVid);
    //document.getElementById('vid'+whichVid).load();
    document.getElementById('vid'+whichVid).style.zIndex--;
    whichVid = (whichVid + 1) % 2;
    document.getElementById('vid'+whichVid).style.zIndex++;
    document.getElementById('vid'+whichVid).play();
    if (vidEnded - vidChanged > 1000) {
        document.getElementById('vid'+whichVid).playbackRate = 1.1;
    } else if(vidEnded - vidChanged < 250) {
        document.getElementById('vid'+whichVid).playbackRate = 0.9;
    } else {
        document.getElementById('vid'+whichVid).playbackRate = 1.0;
    }
}


function addList () {
    document.getElementById('vid0').addEventListener('ended',vidEnd,false);
    document.getElementById('vid1').addEventListener('ended',vidEnd,false);
    document.getElementById('vid0').play();
}

onload = addList;

getNext();

</script>

</head>


<body style="margin: 0px;">


<video style="position:absolute;z-index:9995;width:100%;" name="media" id="vid0">
<source id="thesource0" src="<?=$urltothetime ?>" type="video/mp4">
</video>

<video style="position:absolute;z-index:9994;width:100%;" name="media" id="vid1">
<source id="thesource1" src="" type="video/mp4">
</video>

</body></html>
