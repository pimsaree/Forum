<?php

class Database{

	// Class constructor override
	public function __construct() {
	
	include_once "/lib/webconfig.php"; 	
	
	$this->mysqli =
	   new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
	 
	if ($this->mysqli->connect_errno) {
		echo "Error MySQLi: ("&nbsp. $this->mysqli->connect_errno
		. ") " . $this->mysqli->connect_error;
		exit();
	 }
	   $this->mysqli->set_charset("utf8");
	}
	
	public function runQuery($qry) {
        $result = $this->mysqli->query($qry);
		return $result; 
    }
	
    public function CloseDB() {
        $this->mysqli->close();
    }
 
    public function clearText($text) {
        $text = trim($text);
        return $this->mysqli->real_escape_string($text);
    }
	
	public function totalCount($fieldname, $tablename, $where = "") 
	{
	$q = "SELECT count(".$fieldname.") FROM "
	. $tablename . " " . $where;
			 
	$result = $this->mysqli->query($q);
	$count = 0;
		if ($result) {
			while ($row = mysqli_fetch_array($result)) {
			$count = $row[0];
			}
		}
		return $count;
	}
}