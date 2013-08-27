<?php
/*
// question class written by Kevin Roth 6/19/2008
// http://www.kevinroth.com/
*/

class team {
	var $teamID = '';
	var $divisionID = 0;
	var $city = '';
	var $team = '';
	var $teamName = '';
	
	// Class constructor
	function team($teamID) {
		return $this->getTeam($teamID);
	}
	
	function getTeam($teamID) {
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "teams where teamID = '" . $teamID . "';";
		$qryTeam = mysql_query($sql) or die($sql);
		if ($rstTeam = mysql_fetch_array($qryTeam)) {
			$this->teamID = $teamID;
			$this->divisionID = $rstTeam['divisionID'];
			$this->city = $rstTeam['city'];
			$this->team = $rstTeam['team'];
			if (!empty($rstTeam['displayName'])) {
				$this->teamName = $rstTeam['displayName'];
			} else {
				$this->teamName = $rstTeam['city'] . ' ' . $rstTeam['team'];
			}
			return true;
		} else {
			return false;
		}
	}
	
}
?>
