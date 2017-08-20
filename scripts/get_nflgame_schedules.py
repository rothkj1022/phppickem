import nflgame
import json

from pprint import pprint

## games = nflgame.games_gen(2017)
## # print ( games.schedule )
## for game in games:
##	# print teamname, game.time, game.game_over(), game.away, game.score_away, 'at', game.home, game.score_home
##	print game.time, game.game_over(), game.away, game.score_away, 'at', game.home, game.score_home

# {"week": 11, "meridiem": "PM", "gamekey": "57391", "season_type": "REG", "away": "NE", "year": 2017, "month": 11, "eid": "2017111909", "time": "4:25", "home": "OAK", "wday": "Sun", "day": 19}

for week in 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17:
	for u_game in nflgame.live._games_in_week(2017,week):
		print u_game["gamekey"],u_game["week"],u_game["eid"],u_game["time"],u_game["home"],"0",u_game["away"],"0","0","0"
		# pprint(game)
		# game = json.dumps( u_game )
		# print game[1]
