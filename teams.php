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
$sql = "select t.*, d.conference, d.division ".
	"from " . DB_PREFIX . "teams t ".
	"inner join " . DB_PREFIX . "divisions d on t.divisionid = d.divisionid ".
	"order by d.divisionid";
$query = $mysqli->query($sql);
$conference = '';
$division = '';
while ($row = $query->fetch_assoc()) {
	if ($row['conference'] !== $conference) {
		if ($conference !== '') {
			echo '</td><td>' . "\n";
		}
		echo '<h2><img src="images/logos/' . strtolower($row['conference']) . '_logo.gif" />' . $row['conference'] . '</h2>' . "\n";
	}
	if ($row['division'] !== $division) {
		echo '<h3>' . $row['division'] . '</h3>' . "\n";
	}
	//echo '<img src="images/helmets_small/' . $row['teamID'] . 'R.gif" /> ';
	echo '<a href="schedules.php?team=' . $row['teamID'] . '">' . $row['city'] . ' ' . $row['team'] . '</a><br />' . "\n";
	$conference = $row['conference'];
	$division = $row['division'];
}
$query->free;
?>
		</td>
	</tr>
</table>
<?php
include('includes/footer.php');
