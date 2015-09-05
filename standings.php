<?php
require('includes/application_top.php');

$weekStats = array();
$playerTotals = array();
$possibleScoreTotal = 0;
calculateStats();

include('includes/header.php');
?>
<h1>Standings</h1>
<h2>Weekly Stats</h2>
<div class="table-responsive">
<table class="table table-striped">
	<tr><th align="left">Week</th><th align="left">Winner(s)</th><th>Score</th></tr>
<?php
if (isset($weekStats)) {
	$i = 0;
	foreach($weekStats as $week => $stats) {
		$winners = '';
		if (is_array($stats[winners])) {
			foreach($stats[winners] as $winner => $winnerID) {
				$tmpUser = $login->get_user_by_id($winnerID);
				switch (USER_NAMES_DISPLAY) {
					case 1:
						$winners .= ((strlen($winners) > 0) ? ', ' : '') . trim($tmpUser->firstname . ' ' . $tmpUser->lastname);
						break;
					case 2:
						$winners .= ((strlen($winners) > 0) ? ', ' : '') . $tmpUser->userName;
						break;
					default: //3
						$winners .= ((strlen($winners) > 0) ? ', ' : '') . '<abbr title="' . trim($tmpUser->firstname . ' ' . $tmpUser->lastname) . '">' . $tmpUser->userName . '</abbr>';
						break;
				}
			}
		}
		$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
		echo '	<tr' . $rowclass . '><td>' . $week . '</td><td>' . $winners . '</td><td align="center">' . $stats[highestScore] . '/' . $stats[possibleScore] . '</td></tr>';
		$i++;
	}
} else {
	echo '	<tr><td colspan="3">No weeks have been completed yet.</td></tr>' . "\n";
}

//echo "<pre>\n";
//print_r($playerTotals);
//echo "</pre>\n";

if (ENABLE_BEST_BET) {
	$tieBreakText = "Best Bets";
	$tieBreakKey = "bestBets";

	foreach($playerTotals as $playerID => $stats) {
		$tieBreakValue[$playerID] = $stats['bestBets'];
	}
} else if (ENABLE_MNF) {
	$tieBreakText = "MNF";
	$tieBreakKey = "mnf";

	foreach($playerTotals as $playerID => $stats) {
		$tieBreakValue[$playerID] = $stats['mnf'];
	}
} else {
	$tieBreakText = "Pick Ratio";
	$tieBreakKey = "score";

	foreach($playerTotals as $playerID => $stats) {
		$pickRatio = $stats[score] . '/' . $possibleScoreTotal;
		$pickPercentage = number_format((($stats[score] / $possibleScoreTotal) * 100), 2) . '%';
		$tieBreakValue[$playerID] = $pickRatio . ' (' . $pickPercentage . ')';
	}
}
?>
</table>
</div>

<h2>User Stats</h2>
<div class="row">
<?php if (!ENABLE_MNF) { ?>
	<div class="col-md-4 col-xs-12">
		<b>By Name</b><br />
		<div class="table-responsive">
			<table class="table table-striped">
				<tr><th align="left">Player</th><th align="left">Wins</th><th><?= $tieBreakText ?></th></tr>
			<?php
			if (isset($playerTotals)) {
				uasort($playerTotals, function($a, $b){return strcmp($a['userName'], $b['userName']);});
				//arsort($playerTotals);
				$i = 0;
				foreach($playerTotals as $playerID => $stats) {
					$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
					switch (USER_NAMES_DISPLAY) {
						case 1:
							echo '	<tr' . $rowclass . '><td class="tiny">' . $stats[name] . '</td><td class="tiny" align="center">' . $stats[wins] . '</td><td class="tiny" align="center">' . $tieBreakValue[$playerID] . '</td></tr>';
							break;
						case 2:
							echo '	<tr' . $rowclass . '><td class="tiny">' . $stats[userName] . '</td><td class="tiny" align="center">' . $stats[wins] . '</td><td class="tiny" align="center">' . $tieBreakValue[$playerID] . '</td></tr>';
							break;
						default: //3
							echo '	<tr' . $rowclass . '><td class="tiny"><abbr title="' . $stats[name] . '">' . $stats[userName] . '<abbr></td><td class="tiny" align="center">' . $stats[wins] . '</td><td class="tiny" align="center">' . $tieBreakValue[$playerID] . '</td></tr>';
							break;
					}
					$i++;
				}
			} else {
				echo '	<tr><td colspan="3">No weeks have been completed yet.</td></tr>' . "\n";
			}
			?>
			</table>
		</div>
	</div>
<?php } ?>
	<div class="col-md-4 col-xs-12">
		<b>By Wins</b><br />
		<div class="table-responsive">
			<table class="table table-striped">
				<tr><th align="left">Player</th><th align="center">Wins</th></tr>
			<?php
			if (isset($playerTotals)) {
				//arsort($playerTotals);
				uasort($playerTotals, function($a, $b){return $b['wins'] - $a['wins'];});
				$i = 0;
				foreach($playerTotals as $playerID => $stats) {
					$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
					switch (USER_NAMES_DISPLAY) {
						case 1:
							echo '	<tr' . $rowclass . '><td class="tiny">' . $stats[name] . '</td><td class="tiny" align="center">' . $stats[wins] . '</td></tr>';
							break;
						case 2:
							echo '	<tr' . $rowclass . '><td class="tiny">' . $stats[userName] . '</td><td class="tiny" align="center">' . $stats[wins] . '</td></tr>';
							break;
						default: //3
							echo '	<tr' . $rowclass . '><td class="tiny"><abbr title="' . $stats[name] . '">' . $stats[userName] . '</abbr></td><td class="tiny" align="center">' . $stats[wins] . '</td></tr>';
							break;
					}
					$i++;
				}
			} else {
				echo '	<tr><td colspan="2">No weeks have been completed yet.</td></tr>' . "\n";
			}
			?>
			</table>
		</div>
	</div>
	<div class="col-md-4 col-xs-12">
		<b>By <?= $tieBreakText ?></b><br />
		<div class="table-responsive">
			<table class="table table-striped">
				<tr><th align="left">Player</th><th align="center"><?= $tieBreakText ?></th></tr>
			<?php
			if (isset($playerTotals)) {
				uasort($playerTotals, function($a, $b){global $tieBreakKey; return $b[$tieBreakKey] - $a[$tieBreakKey];});
				$i = 0;
				foreach($playerTotals as $playerID => $stats) {
					$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
					switch (USER_NAMES_DISPLAY) {
						case 1:
							echo '	<tr' . $rowclass . '><td class="tiny">' . $stats[name] . '</td><td class="tiny" align="center">' . $tieBreakValue[$playerID] . '</td></tr>';
							break;
						case 2:
							echo '	<tr' . $rowclass . '><td class="tiny">' . $stats[userName] . '</td><td class="tiny" align="center">' . $tieBreakValue[$playerID] . '</td></tr>';
							break;
						default: //3
							echo '	<tr' . $rowclass . '><td class="tiny"><abbr title="' . $stats[name] . '">' . $stats[userName] . '</abbr></td><td class="tiny" align="center">' . $tieBreakValue[$playerID] . '</td></tr>';
							break;
					}
					$i++;
				}
			} else {
				echo '	<tr><td colspan="3">No weeks have been completed yet.</td></tr>' . "\n";
			}
			?>
			</table>
		</div>
	</div>
<?php if (ENABLE_MNF) { ?>
	<div class="col-md-4 col-xs-12">
		<b>By MNF</b><br />
		<div class="table-responsive">
			<table class="table table-striped">
				<tr><th align="left">Player</th><th>MNF</th></tr>
			<?php
			if (isset($playerTotals)) {
				uasort($playerTotals, function($a, $b){return $b['mnf'] - $a['mnf'];});
				//arsort($playerTotals);
				$i = 0;
				foreach($playerTotals as $playerID => $stats) {
					$rowclass = (($i % 2 == 0) ? ' class="altrow"' : '');
					switch (USER_NAMES_DISPLAY) {
						case 1:
							echo '	<tr' . $rowclass . '><td class="tiny">' . $stats[name] . '</td><td class="tiny" align="center">' . $stats['mnf'] . '</td></tr>';
							break;
						case 2:
							echo '	<tr' . $rowclass . '><td class="tiny">' . $stats[userName] . '</td><td class="tiny" align="center">' . $stats['mnf'] . '</td></tr>';
							break;
						default: //3
							echo '	<tr' . $rowclass . '><td class="tiny"><abbr title="' . $stats[name] . '">' . $stats[userName] . '<abbr></td><td class="tiny" align="center">' . $stats['mnf'] . '</td></tr>';
							break;
					}
					$i++;
				}
			} else {
				echo '	<tr><td colspan="3">No weeks have been completed yet.</td></tr>' . "\n";
			}
			?>
			</table>
		</div>
	</div>
<?php } ?>
</div>

<?php
include('includes/comments.php');

include('includes/footer.php');
?>
