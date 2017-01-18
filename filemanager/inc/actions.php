<?php
require_once(__DIR__.'/functions.php');
if (empty($_REQUEST) === false) {
	if (empty($_REQUEST['action']) === false) {
		$func = $_REQUEST['action'];
		if (function_exists($func)) {
			$func($_REQUEST['path']);
		}else{
			echo 'Function Not Exists';
		}
	}
}

?>