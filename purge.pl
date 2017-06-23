#!/usr/bin/perl

# Name of camera.
$cam = $ARGV[0];

# Keep this many days
$days = $ARGV[1];

for ($i = $days + 10 ; $i > $days ; $i--) {
    ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time - $i * 60 * 60 * 24);
    $location = "~/security/".$cam."/".($year + 1900)."/".sprintf("%02d", ($mon + 1))."/".sprintf("%02d", $mday);
    $cmd = "rm -rf ".$location;
    #print "$cmd\n";
    `$cmd`;
}
