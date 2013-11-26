#!/usr/bin/perl
use strict;
use warnings;
use Data::Dumper;
use DateTime::Event::Sunrise;

sub getNow
{
	return DateTime->now(time_zone  => 'Europe/Berlin');
}

sub calcSunsetForToday
{
	# for duesseldorf
	my $lat = +51.2288;
	my $lng = -6.7751;

	my $sunrise = DateTime::Event::Sunrise->new(
		longitude => $lng,
		latitude => $lat,
	);

	my $now = getNow();

	return  $sunrise->sunset_datetime($now);
}

sub updateDateAndSunset
{
	my $sunset = calcSunsetForToday();

	print "On ".$sunset->ymd." sunset occurs at ".$sunset->hms.".\n";
	return $sunset;
}

my $sunset = updateDateAndSunset();
my $sleepTime = 0;

while(1)
{
	print "Sleeping for $sleepTime seconds...\n";
	sleep($sleepTime);

	my $now = getNow();
	if( $now->ymd ne $sunset->ymd ) {
		print "Date change detected. Refreshing date and sunset.\n";
		$sunset = updateDateAndSunset();
	}

	my $delta = $sunset->subtract_datetime($now);
	if($delta->in_units("minutes") > 10) {
		$sleepTime = 600;
		print "It's ".$now->hms." now. A long way until ".$sunset->hms.". Let's sleep for 10 Minutes.\n";
		next;
	} else {
		$sleepTime = 10; 
	}

	print "TODO: Check for MAC on Network\n";
}
