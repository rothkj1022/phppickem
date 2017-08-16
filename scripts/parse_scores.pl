#! /usr/bin/perl -w # -Dv

##
## <?xml version="1.0" encoding="UTF-8" ?>
##
## <script name="parse_scores.pl">
##

# [ pragma declarations ]

	use URI::Escape

# [ global constants ]

	$|++ ;

	$DEBUG = $ENV { 'DEBUG' } ;

	%TEAM_HASH = (

		'Arizona'       => 'ARI' ,
		'Atlanta'       => 'ATL' ,
		'Baltimore'     => 'BAL' ,
		'Buffalo'       => 'BUF' ,
		'Carolina'      => 'CAR' ,
		'Chicago'       => 'CHI' ,
		'Cincinnati'    => 'CIN' ,
		'Cleveland'     => 'CLE' ,
		'Dallas'        => 'DAL' ,
		'Denver'        => 'DEN' ,
		'Detroit'       => 'DET' ,
		'Green_Bay'     => 'GB' ,
		'Houston'       => 'HOU' ,
		'Indianapolis'  => 'IND' ,
		'Jacksonville'  => 'JAX' ,
		'Kansas_City'   => 'KC' ,
		'LA_Chargers'   => 'LAC' ,
		'LA_Rams'       => 'LAR' ,
		'Miami'         => 'MIA' ,
		'Minnesota'     => 'MIN' ,
		'New_England'   => 'NE' ,
		'New_Orleans'   => 'NO' ,
		'NY_Giants'     => 'NYG' ,
		'NY_Jets'       => 'NYJ' ,
		'Oakland'       => 'OAK' ,
		'Philadelphia'  => 'PHI' ,
		'Pittsburgh'    => 'PIT' ,

		'Seattle'       => 'SEA' ,
		'San_Francisco' => 'SF' ,
		'Tampa_Bay'     => 'TB' ,
		'Tennessee'     => 'TEN' ,
		'Washington'    => 'WAS' ,

	) ;

# [ script body ]

	# $escaped_scores = `curl -s http://sports.espn.go.com/nfl/bottomline/scores` ;
	$escaped_scores = `curl -s http://www.espn.com/nfl/bottomline/scores` ;

	$escaped_scores =~ s/\&nfl_.*?=/\n/g ;

	$scores = uri_unescape($escaped_scores) ;

	# $scores =~ s/([A-Z].*?) ([A-Z].*?)/$1_$2/g ;

	print ( "$scores\n" ) if ( $DEBUG ) ;

	@lines = split ( "\n" , $scores ) ;

	shift ( @lines ) ;

	$nfl_s_delay = shift ( @lines ) ;

	print ( "nfl_s_delay = $nfl_s_delay\n" ) if ( $DEBUG ) ;

	$nfl_s_stamp = shift ( @lines ) ;

	print ( "nfl_s_stamp = $nfl_s_stamp\n" ) if ( $DEBUG ) ;

	$nfl_s_count = pop ( @lines ) ;

	print ( "nfl_s_count = $nfl_s_count\n" ) if ( $DEBUG ) ;

	$nfl_s_loaded = pop ( @lines ) ;

	print ( "nfl_s_loaded = $nfl_s_loaded\n" ) if ( $DEBUG ) ;

	foreach ( @lines )
	{
		next if ( /^0/ ) ;

		next if ( /^http/ ) ;

		s/\^//g ;

		# s/([A-Z]\D+) ([A-Z]\D+)/$1_$2/g ;

		print ">>> $_\n" if ( $DEBUG ) ;

		if ( ( $T1 , $S1 , $T2 , $S2 , $F ) = m:(\D+) (\d+)\s+(\D+) (\d+) \((.*)\): )
		{
			print ( "F = $F\n" ) if ( $DEBUG ) ;

			$FF = ( /FINAL|END OF 4TH|00:00 IN 4TH|00:00 IN OT/ ) ? 1 : 0 ;

			print ( "FF = $FF\n" ) if ( $DEBUG ) ;

			$OT = ( /OT/ ) ? 1 : 0 ;

			print ( "OT = $OT\n" ) if ( $DEBUG ) ;

			$T1 =~ s/ /_/g;

			printf ( "%-14s - %d\n" , $T1 , $S1 ) if ( $DEBUG ) ;

			$T2 =~ s/ /_/g;

			printf ( "%-14s - %d\n" , $T2 , $S2 ) if ( $DEBUG ) ;

			printf ( "update nflp_schedule set homeScore = %d , visitorScore = %d , overtime = %d , final = %d where homeID = '%s' and visitorID = '%s' ;\n" , $S2 , $S1 , $OT , $FF , $TEAM_HASH{$T2} , $TEAM_HASH{$T1} ) ;
		}
	}

	exit ( 0 ) ;

##
## </script>
##
