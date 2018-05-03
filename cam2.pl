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

$stream = $ARGV[5];

$starttime = time;
$offset = ($starttime - $delay) % (20*60);

# 20 minutes minus any delay to start this script minus 1 second to ensure no overlap (camera might only allow one rtsp feed).
$recordtime = 20*60 - $offset - 1;
$thumbtime = $recordtime / 100;

my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time);

$filename = "~/security/".$cam."/".($year + 1900)."/".sprintf("%02d", $mon + 1)."/".sprintf("%02d", $mday)."/";
$tempfilename = "~/ramdisk/".$cam."/".($year + 1900)."/".sprintf("%02d", $mon + 1)."/".sprintf("%02d", $mday)."/";



$cmd = "mkdir -p $filename;mkdir -p $tempfilename";
`$cmd`;

$title = sprintf("%02d", $hour).sprintf("%02d", $min);
$filename = $filename.$title;
$tempfilename = $tempfilename.$title;


$gifthumbname = $filename."_th.jpg";
$thname = $filename."_100x.mp4";
#$noextension = $filename;
$filename = $filename.".mp4";

# Primary recording takes place here.
$cmd = "ffmpeg -rtsp_transport tcp -i rtsp://".$user.":".$password."\@".$ip."/".$stream.":554 -metadata title=\"".$title."\" -vcodec copy -an -t ".$recordtime." ".$filename." -vcodec h264 -s 320x180 -r 60 -filter:v \"setpts=0.01*PTS\" -an -t ".$thumbtime." ".$thname." -vframes 1 -s 320x180 ".$gifthumbname." -vcodec copy -f segment -segment_time 2 -an -t ".$recordtime." ".$tempfilename."_seg_%05d.mp4";
`$cmd`;


$cmd = "sleep 20;rm -f ".$tempfilename."_seg_*";
`$cmd`;
