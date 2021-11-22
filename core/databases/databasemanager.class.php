<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2015 The Open University UK                                   *
 *                                                                              *
 *  This software is freely distributed in accordance with                      *
 *  the GNU Lesser General Public (LGPL) license, version 3 or later            *
 *  as published by the Free Software Foundation.                               *
 *  For details see LGPL: http://www.fsf.org/licensing/licenses/lgpl.html       *
 *               and GPL: http://www.fsf.org/licensing/licenses/gpl-3.0.html    *
 *                                                                              *
 *  This software is provided by the copyright holders and contributors "as is" *
 *  and any express or implied warranties, including, but not limited to, the   *
 *  implied warranties of merchantability and fitness for a particular purpose  *
 *  are disclaimed. In no event shall the copyright owner or contributors be    *
 *  liable for any direct, indirect, incidental, special, exemplary, or         *
 *  consequential damages (including, but not limited to, procurement of        *
 *  substitute goods or services; loss of use, data, or profits; or business    *
 *  interruption) however caused and on any theory of liability, whether in     *
 *  contract, strict liability, or tort (including negligence or otherwise)     *
 *  arising in any way out of the use of this software, even if advised of the  *
 *  possibility of such damage.                                                 *
 *                                                                              *
 ********************************************************************************/
/**
 * databasemanager.class.php
 *
 * Michelle Bachler (KMi)
 *
 * Manages sql execution.
 */

/* LOAD THE DATABASE UTILLIB */
include_once($HUB_FLM->getCodeDirPath("core/databases/databaseutillib.php"));

///////////////////////////////////////
// DatabaseManager Class
///////////////////////////////////////

class DatabaseManager {

	/**
	 * If you add a new type of database please add the name to this list (one word,lowercase)
	 * and then the config files should reference it.
	 * The name you add here should also be the name of the folder containing any database specfic sql overrides that are required.
	 * Also check/extend statments in functions further down this manager class that branch depending on database type.
	 */
	private $DATABASE_TYPE_MYSQL = "mysql";
	private $DATABASE_TYPE_ODBC = "odbc";
	private $databasetype = "mysql";

 	private $CUSTOMFOLDER = 'custom';
	private $DEFAULTSQL = 'default';

	public $conn;

	/**
	 * Constructor
 	 *
	 * @return DatabaseManager (this)
	 */
	function DatabaseManager($databasetype = "") {
		if (isset($databasetype) && $databasetype != "") {
			$this->databasetype = $databasetype;
		}

		$this->createConnection();
	}

	function createConnection() {
		if ($this->databasetype == $this->DATABASE_TYPE_MYSQL) {
			return $this->createMySQLConnection();
		} else if ($this->databasetype == $this->DATABASE_TYPE_ODBC) {
			return $this->createODBCConnection();
		} else {
			die($LNG->DATABASE_UNKNOWN_TYPE_ERROR);
		}
	}

	function createMySQLConnection() {
		global $CFG, $LNG;

		$this->conn = new mysqli($CFG->databaseaddress, $CFG->databaseuser, $CFG->databasepass, $CFG->databasename);
		if($this->conn->connect_errno > 0){
			 error_log("Errno: " . $this->conn->connect_errno);
			 error_log("Error: " . $this->conn->connect_error);
			 die($LNG->DATABASE_CONNECTION_ERROR);
		}
	}

	function createODBCConnection() {
		global $CFG, $LNG;
		$this->conn  = odbc_connect($CFG->databaseaddress, $CFG->databaseuser, $CFG->databasepass);
		if (!$this->conn) {
			die($LNG->DATABASE_CONNECTION_ERROR);
			//echo odbc_errormsg();
		} else {
	    	//connect to specified database
			$sql = "USE ".$CFG->databasename;
			odbc_exec ( $this->conn, $sql);
			//echo odbc_errormsg();
		}
	}

	function setDatabaseType($databasetype = "") {
		$this->databasetype = $databasetype;
	}

	/**
	 * Create the SQL ORDER BY clause for nodes
	 *
	 * @param string $o order by column
	 * @param string $s sort order (ASC or DESC)
	 * @return string
	 */
	function nodeOrderString($sql, $o,$s) {
		return $sql.nodeOrderString($o,$s);
	}

	/**
	 * Create the SQL ORDER BY clause for users
	 *
	 * @param string $sql the sql string being ordered.
	 * @param string $o order by column
	 * @param string $s sort order (ASC or DESC)
	 * @return string
	 */
	function userOrderString($sql, $o, $s) {
		return $sql.userOrderString($o,$s);
	}

	/**
	 * Create the SQL ORDER BY clause for groups
	 *
	 * @param string $sql the sql string being ordered.
	 * @param string $o order by column
	 * @param string $s sort order (ASC or DESC)
	 * @return string
	 */
	function groupOrderString($sql, $o, $s) {
		return $sql.groupOrderString($o,$s);
	}

	/**
	 * Create the SQL ORDER BY clause for urls
	 *
	 * @param string $sql the sql string being ordered.
	 * @param string $o order by column
	 * @param string $s sort order (ASC or DESC)
	 * @return string
	 */
	function urlOrderString($sql, $o, $s) {
		return $sql.urlOrderString($o,$s);
	}

	/**
	 * Create the SQL ORDER BY clause for connections
	 *
	 * @param string $sql the sql string being ordered.
	 * @param string $o order by column
	 * @param string $s sort order (ASC or DESC)
	 * @return string
	 */
	function connectionOrderString($sql, $o, $s) {
		return $sql.connectionOrderString($o,$s);
	}

	/**
	 * Modifiy the SQL statement passed to LIMIT the number of records returned
	 *
	 * @param string $sql the sql string being limited.
	 * @param integer $start start row (default 0)
	 * @param integer $max max number of rows to return (default 20)
	 * @return string the modified sql statement.
	 */
	function addLimitingResults($sql, $start, $max) {
		$newsql = $sql;

		if (!isset($start)) {
			$start = 0;
		}
		if (!isset($max)) {
			$max = 20;
		}

		if ($max > -1) {
			if ($this->databasetype == $this->DATABASE_TYPE_MYSQL) {
				$newsql .= " LIMIT ". $start.",".$max;
			} else if ($this->databasetype == $this->DATABASE_TYPE_ODBC) {
				$newsql = "SELECT TOP ".$start.",".$max." * from (".$sql.") as temp";
			}
		}
		return $newsql;
	}

	/**
	 * Clean the passed string
	 *
	 * @param string $text to clean.
	 * @return string the modified string.
	 */
	function cleanString($text) {
		$newtext = $text;
		if ($this->databasetype == $this->DATABASE_TYPE_MYSQL) {
			$newtext = $this->conn->real_escape_string($text);
		} else if ($this->databasetype == $this->DATABASE_TYPE_ODBC) {
			$newtext = addslashes($text);
		}
		return $newtext;
	}


	function insert($sql, $params) {
		if ($this->databasetype == $this->DATABASE_TYPE_MYSQL) {
			return $this->insertIntoMySQL($sql, $params);
		} else if ($this->databasetype == $this->DATABASE_TYPE_ODBC) {
			return $this->insertIntoODBC($sql, $params);
		}
	}

	function insertIntoMySQL($sql, $params) {
		$pos = 0;
		$i = 0;
		while( ($nextpos = strpos($sql, '?', $pos)) !== false) {
			$next = $params[$i];
			if (is_string($next)) {
				$next = "'".$this->conn->real_escape_string($next)."'";
			}
			$sql = substr_replace ($sql, $next, $nextpos, 1);
			$pos = $nextpos+strlen($next);
			$i++;
		}
    	//echo $sql;

    	$results = $this->conn->query($sql);
    	if (!$results) {
	    	error_log(print_r($sql, true));
	    	error_log(print_r($results, true));
			error_log("Errno: " . $this->conn->errno);
			error_log("Error: " . $this->conn->error);
    	}

		return $results;
	}

	function insertIntoODBC($sql, $params) {
		$results = odbc_prepare($this->conn, $sql);

		if($results === false) {
			error_log(print_r($params, true));
			error_log($sql);
		    return false;
		}

		if(odbc_execute($results, $params) === false) {
			error_log(print_r($params, true));
			error_log($sql);
			return false;
		}

		return $results;
	}

	function select($sql, $params) {
		if ($this->databasetype == $this->DATABASE_TYPE_MYSQL) {
			return $this->selectFromMySQL($sql, $params);
		} else if ($this->databasetype == $this->DATABASE_TYPE_ODBC) {
			return $this->selectFromODBC($sql, $params);
		}
	}

	function selectFromMySQL($sql, $params) {
		//error_log(print_r($params, true));
		$pos = 0;
		$i = 0;
		//error_log(print_r($sql, true));
		while( ($nextpos = strpos($sql, '?', $pos)) !== false) {
			//error_log($pos);

			$next = $params[$i];
			if (is_string($next)) {
				$next = "'".$this->conn->real_escape_string($next)."'";
			}
			/*else if ($next instanceof stdClass) {
				// used when string does not want to have speech marks added - as with like statements using %
				if (isset($next->value)) {
					$next = $this->conn->real_escape_string($next->value);
				} else {
					$next = '';
				}
			}*/

			// If it is an undefined variable assume it is a string.
			// Really need to fix code to always store empty string not nothing when userid missing.
			if (!isset($next)) {
				$next = "''";
			}
			$sql = substr_replace ($sql, $next, $nextpos, 1);
			$pos = $nextpos+strlen($next);
			$i++;
		}

		//error_log($sql);

    	$results = $this->conn->query($sql);

		if (!$results) {
	    	error_log(print_r($sql, true));
	    	error_log(print_r($results, true));
			error_log("Errno: " . $this->conn->errno);
			error_log("Error: " . $this->conn->error);
			return false;
		} else {
		    //error_log(print_r("HERE", true));
			//load results into an array of row arrays
			$resultArray = array();
			while ($row = $results->fetch_assoc()) {
				array_push($resultArray, $row);
			}
        	return $resultArray;
		}
	}

	function selectFromODBC($sql, $params) {
		//error_log(print_r($params, true));
		//error_log($sql);
		//error_log(print_r(debug_backtrace(), true));

		// pre-process params to remove stdClass - needed in MySQL version
		/*
		$count = 0;
		if(is_countable($params)) {
			$count = count($params);
		}
		for ($i=0; $i < $count; $i++) {
			$next = $params[$i];
			if ($next instanceof stdClass) {
				if (isset($next->value)) {
					$next = $next->value;
				} else {
					$next = '';
				}
				$params[$i] = $next;
			}
		}*/

		$results = odbc_prepare($this->conn, $sql);

		if($results === false) {
			error_log(print_r($params, true));
			error_log($sql);
			//echo "FRED1 ".odbc_errormsg($this->conn);
		    return false;
		}

		if(odbc_execute($results, $params) === false) {
			//echo "FRED2 ".odbc_error($this->conn);
			return false;
		} else {
			//load results into an array of row arrays
			$resultArray = array();

			//error_log(odbc_num_rows($results));
			//error_log(print_r($results,true));

			if (odbc_num_rows($results) > 0) {
				while($row = odbc_fetch_array($results) ) {
					array_push($resultArray, $row);
				}
			}
			return $resultArray;
		}
	}

	function delete($sql, $params) {
		if ($this->databasetype == $this->DATABASE_TYPE_MYSQL) {
			return $this->deleteFromMySQL($sql, $params);
		} else if ($this->databasetype == $this->DATABASE_TYPE_ODBC) {
			return $this->deleteFromODBC($sql, $params);
		}
	}

	function deleteFromMySQL($sql, $params) {
		$pos = 0;
		$i = 0;
		while( ($nextpos = strpos($sql, '?', $pos)) !== false) {
			$next = $params[$i];
			if (is_string($next)) {
				$next = "'".$this->conn->real_escape_string($next)."'";
			}
			$sql = substr_replace ($sql, $next, $nextpos, 1);
			$pos = $nextpos+strlen($next);
			$i++;
		}
    	//echo $sql;

    	$results = $this->conn->query($sql);
		return $results;
	}

	function deleteFromODBC($sql, $params) {
		$results = odbc_prepare($this->conn, $sql);

		if($results === false) {
		    // throw new ErrorException(odbc_errormsg());
		    return false;
		}

		if(odbc_execute($results, $params) === false) {
			return false;
			//throw new ErrorException(odbc_errormsg());
		}

		return $results;
	}

	/**
	 * Check is there is a local customization for the given file.
	 * If so return true, else false.
	 *
	 * $file, the default file path of the code file to check.
	 * This is the full path and filename as would be used in a script statement.
	 * returns true if there is a Custom file, else false.
	 */
	/*function hasCustomVersion($file) {
		global $CFG;

		// DOMAIN SPECIFIC FILE - MULTI AND DEFAULT
		if (file_exists($CFG->dirAddress.$CFG->domainfolder.'custom/'.$file)) {
			return true;

		// MULTI SITE GLOBAL FILE
		} else if ($CFG->ismultidomain &&
				file_exists($CFG->dirAddress.'sites/multi/all/custom/'.$file)) {
			return true;
		}
		return false;
	}*/
}