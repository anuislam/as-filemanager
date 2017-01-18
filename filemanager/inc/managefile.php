<?php

//**********************************
// Manage files like copy, move, create, delete
//**********************************

class Managefile
{
	//**********************************
	// Create new folder
	//**********************************
	public function create_folder($name){
		if (!file_exists($name)) {
			if (@mkdir($name)) {
				return true;
			}else{
				return false;
			}			
		}else{
			return true;
		}
	}

	public function create_file($name){
		$file = @fopen("$name", "w") or die("Unable to open file!");
		fclose($file);	
	}

	public function recurse_copy($src,$dst) {
		$ck = true;
		if (is_dir($src)) {
		    $dir = opendir($src); 
		    (!file_exists($dst)) ? @mkdir($dst) : null ;
		    while(false !== ( $file = readdir($dir)) ) { 
		        if (( $file != '.' ) && ( $file != '..' )) { 
		            if ( is_dir($src . '/' . $file) ) { 
		                $this->recurse_copy($src . '/' . $file,$dst . '/' . $file); 
		            } 
		            else { 
		                if (@!copy($src . '/' . $file,$dst . '/' . $file)) {
		                	$ck = false;
		                }else{
		                	$ck = true;
		                }
		            } 
		        } 
		    } 
		    closedir($dir); 
		}else{			
			(!file_exists($dst)) ? @mkdir($dst) : null ;
			$name = explode('/', $src);
			$newfile = end($name);
			if (@!copy($src, $dst.'/'.$newfile)) {
				$ck = false;
			}else{
            	$ck = true;
            }
		}
		return $ck;
	}
}
?>