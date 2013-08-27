<?php
require_once('includes/application_top.php');
require_once('includes/header.php');
?>

<h1>Teams</h1>
<p>Click on a team below to see their schedule.</p>
<table>
	<tr valign="top">
		<td>
<?php
$sql = "select t.*, d.conference, d.division
from " . $db_prefix . "teams t
inner join " . $db_prefix . "divisions d on t.divisionid = d.divisionid
order by d.divisionid";
$query = mysql_query($sql);
$conference = '';
$division = '';
while ($result = mysql_fetch_array($query)) {
	if ($result['conference'] !== $conference) {
		if ($conference !== '') {
			echo '</td><td>' . "\n";
		}
		echo '<h2><img src="images/logos/' . strtolower($result['conference']) . '_logo.gif" />' . $result['conference'] . '</h2>' . "\n";
	}
	if ($result['division'] !== $division) {
		echo '<h3>' . $result['division'] . '</h3>' . "\n";
	}
	//echo '<img src="images/helmets_small/' . $result['teamID'] . 'R.gif" /> ';
	echo '<a href="schedules.php?team=' . $result['teamID'] . '">' . $result['city'] . ' ' . $result['team'] . '</a><br />' . "\n";
	$conference = $result['conference'];
	$division = $result['division'];
}
?>
		</td>
	</tr>
</table>
<?php
include('includes/footer.php');
?>
