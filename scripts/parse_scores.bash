#! /bin/bash

##
## <?xml version="1.0" encoding="UTF-8" ?>
##
## <script name="parse_scores.bash">
##

	parse_scores.pl 1> /tmp/parse_scores.sql

	mysql --defaults-file=${HOME}/.mysql.d/localhost.cnf nflpickem < /tmp/parse_scores.sql

##
## </script>
##
