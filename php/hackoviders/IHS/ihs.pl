#use strict;

my $cmd = 'java -cp annotator-for-clinical-data-1.1.1.jar;core-6.9.3.jar;ibm-watson-8.5.0-jar-with-dependencies.jar;ibm-whcs-services-common-1.1.1.jar;IHS.jar;insights-for-medical-literature-1.1.1.jar IHSApp "Patient has lung cancer, but did not smoke. She may consider chemotherapy as part of a treatment plan. mucinex, paracetamol"';

my $res = `$cmd`;

my @arr = split ("\n", $res);
my %data;
foreach my $arr  (@arr) {
	my ($key, $value) = split (":", $arr);
	$data{$key} = substr($value, 0, -1);
#	print "\n\n$arr\n\n";
}

#my %data = map { $_->{key} => $_->{value} } @arr;

while (my ($key, $value) = each(%data))
{
     print "$key = $value\n";
}

