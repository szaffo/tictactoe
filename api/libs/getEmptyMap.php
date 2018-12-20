<?php 

	function getEmptyMap($x,$y) {
		$table = system("./createTable.py {$x} {$y}", $returnVal);
		// $returnVal = shell_exec("$?");

		if ($returnVal == 0) {
			return $table;
		} else {
			return $returnVal;
		}

	}
	
 ?>