<?php


class dbConnection {

	var $db;	

	function open($dbhost, $dbuser, $dbpass, $dbname)
	{
		$this->db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
		mysqli_query($this->db, "SET NAMES 'utf8'");
	}

	function q($query) {
		$result = mysqli_query($this->db, $query);

		return $result;
	}


}

?>