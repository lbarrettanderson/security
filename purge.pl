#!/usr/bin/perl

# Name of camera.
$cam = $ARGV[0];

# Keep this many days
$days = $ARGV[1];


my @abbr = qw(Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec);


for ($i = $days + 10 ; $i > $days ; $i--) {
    ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime(time - $i * 60 * 60 * 24);
    $location = "~/security/".$cam."/".($year + 1900)."/".$abbr[$mon]."/".sprintf("%02d", $mday);
    $cmd = "rm -rf ".$location;
    #print "$cmd\n";
    `$cmd`;
}
