#!/usr/bin/perl

# Name of camera.
$cam = $ARGV[0];

# IP Address of camera
$ip = $ARGV[1];

# Offset of cronjob in seconds (if job is run every 20 minutes starting at 5 minutes after the hour, for example, value would be 300).
# I offset the times since I have multiple cameras and I don't want them doing heavy work at the same time (encoding or writing to disk or initializing the video feed).
$delay = $ARGV[2];

# RTSP feed login info.
$user = $ARGV[3];
$password = $ARGV[4];

$starttime = time;
$offset = ($starttime - $delay) % (20*60);

# 20 minutes minus any delay to start this script minus 1 second to ensure no overlap (camera might only allow one rtsp feed).
$recordtime = 20*60 - $offset - 1;
$thumbtime = $recordtime / 100;

my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);

$filename = "~/security/".$cam."/".($year + 1900)."/".sprintf("%02d", $mon + 1)."/".sprintf("%02d", $mday)."/";

$cmd = "mkdir -p $filename";
`$cmd`;

$title = sprintf("%02d", $hour).sprintf("%02d", $min);
$filename = $filename.$title;

$gifthumbname = $filename."_th.jpg";
$thname = $filename."_100x.mp4";
$filename = $filename.".mp4";

# Primary recording takes place here.
$cmd = "ffmpeg -rtsp_transport tcp -i rtsp://".$user.":".$password."\@".$ip."/11:554 -metadata title=\"".$title."\" -vcodec copy -an -t ".$recordtime." ".$filename." -vcodec h264 -s 320x180 -r 60 -filter:v \"setpts=0.01*PTS\" -an -t ".$thumbtime." ".$thname;
`$cmd`;

# Grab single image for thumbnail .1 seconds into 100x video (sometimes there's some noise at the very beginning).
$cmd = "nice -5 ffmpeg -i ".$thname." -ss .1 -vframes 1 ".$gifthumbname;
`$cmd`;
