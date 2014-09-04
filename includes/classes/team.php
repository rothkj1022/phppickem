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
		global $mysqli;
		$sql = "select * from " . DB_PREFIX . "teams where teamID = '" . $teamID . "';";
		$query = $mysqli->query($sql) or die($sql);
		if ($row = $query->fetch_assoc()) {
			$this->teamID = $teamID;
			$this->divisionID = $row['divisionID'];
			$this->city = $row['city'];
			$this->team = $row['team'];
			if (!empty($row['displayName'])) {
				$this->teamName = $row['displayName'];
			} else {
				$this->teamName = $row['city'] . ' ' . $row['team'];
			}
			return true;
		} else {
			return false;
		}
		$query->free;
	}

}
