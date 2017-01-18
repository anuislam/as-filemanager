<?php

//**********************************
// Include file for class
//**********************************

require_once __DIR__ . '/zipclass.php';
require_once __DIR__ . '/managefile.php';

//**********************************
// Get file size Without folder
//**********************************

function get_file_size($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' kB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = 'Folder';
    }
    
    return $bytes;
}
//**********************************
// All functions for file manager requirement
//**********************************

//**********************************
// Delete file
//**********************************

function delete_file($path = null)
{
    if (file_exists($path) === true) {
        if (is_dir($path)) {
            echo delet_folder($path);
        } else {
            if (unlink($path)) {
                echo 'File Deleted';
            } else {
                echo 'Opss somethis is wrong!';
            }
        }
    } else {
        echo 'File Not Exists';
    }
}


//**********************************
// Delete folder
//**********************************

function delet_folder($dir)
{
    $files = array_diff(scandir($dir), array(
        '.',
        '..'
    ));
    if (empty($files) === false) {
        if (is_array($files) === true) {
            foreach ($files as $file) {
                if (is_dir("$dir/$file")) {
                    delet_folder("$dir/$file");
                }else{
                    unlink("$dir/$file");
                }

            }
        }
    }
    return @(rmdir($dir)) ? 'Folder Deleted' : 'Opss somethis is wrong!';
}

//**********************************
// Rename file and folder
//**********************************

function rename_file($data = null)
{
    if (empty($_POST) === false) {
        $oldname  = trim($_POST['path']);
        $newname  = trim($_POST['newname']);
        $realpath = trim($_POST['realpath']);
        $error_ck = false;
        if (empty($oldname) === false && isset($oldname) === true) {
            $error_ck = true;
        }
        if (empty($newname) === false && isset($newname) === true) {
            $error_ck = true;
        }
        if (empty($realpath) === false && isset($realpath) === true) {
            $error_ck = true;
        }
        if ($error_ck === true) {
            if (file_exists($oldname)) {
                if (file_exists($realpath . $newname)) {
                    echo 'File name allready exiests Please choose another name.';
                } else {
                    if (preg_match('/^[A-Za-z0-9.\- ]+$/i', $newname)) {
                        if (rename($oldname, $realpath . $newname)) {
                            echo 'File was renamed.';
                        }
                    } else {
                        echo 'Invalid name';
                    }
                }
            } else {
                echo 'Missing file.';
            }
        }
    }
}

//**********************************
// create zip
//**********************************

function creat_zip_file()
{
    if (empty($_POST) === false) {
        $arrfile  = $_POST['arrfile'];
        $realpath = $_POST['realpath'];
        $name     = $_POST['name'] . '.zip';
        $error_ck = false;
        if (empty($arrfile) === false && isset($arrfile) === true) {
            $error_ck = true;
        }
        if (empty($realpath) === false && isset($realpath) === true) {
            $error_ck = true;
        }
        if (empty($name) === false && isset($name) === true) {
            $error_ck = true;
        }
        if ($error_ck === true) {
            $zipper = new Zipclass();
            if (is_array($arrfile)) {
                if (preg_match('/^[A-Za-z0-9.\- ]+$/i', $name)) {
                    $zipper->add($arrfile);
                    $zipper->zip_create("$realpath/$name");
                    echo 'successfully';
                } else {
                    echo 'Invalid name';
                }
            } else {
                echo 'Invalid Data.';
            }
        }
        
    }
    
}


//**********************************
// Copy folders and files
//**********************************

function copy_file()
{
    if (empty($_POST) === false) {
        $arrfile    = $_POST['arrfile'];
        $copy_path  = $_POST['copy_path'];
        $ck = false;
        if (isset($copy_path) && isset($arrfile)) {
            if (is_array($arrfile)) {
                $manager = new Managefile();
                foreach ($arrfile as $key => $value) {
                   if (!file_exists($value)) {
                       unset($key);
                   }else{
                    if ($manager->recurse_copy($value, $copy_path) === true) {
                        $ck = true;
                    }
                   }
                }
            }
        }
        if ($ck === true) {
            echo 'successfully';
        }else{
            echo 'Oops something is wrong!';
        }
    }
}

//**********************************
// Move file and folder
//**********************************



function move_file()
{
    if (empty($_POST) === false) {
        $arrfile    = $_POST['arrfile'];
        $copy_path  = $_POST['copy_path'];
        $ck = false;
        if (isset($copy_path) && isset($arrfile)) {
            if (is_array($arrfile)) {
                $manager = new Managefile();
                foreach ($arrfile as $key => $value) {
                   if (!file_exists($value)) {
                       unset($key);
                   }else{
                        if ($manager->recurse_copy($value, $copy_path) === true) {                        
                            if (is_dir($value)) {
                                delet_folder($value);
                                $ck = true;
                            }else{
                                delete_file($value);
                                $ck = true;
                            }
                            $ck = true;
                        }
                   }
                }
            }
        }
        if ($ck === true) {
            echo 'successfully';
        }else{
            echo 'Oops something is wrong!';
        }
    }
}


//**********************************
// zip file validation
//**********************************

function zip_validation()
{
    if (empty($_POST) === false) {
        $arrfile = $_POST['arrfile'];
        $gettype = array();
        $msg     = '';
        if (empty($arrfile) === false && isset($arrfile) === true) {
            if (is_array($arrfile)) {
                foreach ($arrfile as $key => $value) {
                    if (!file_exists($value)) {
                        unset($key);
                    } else {
                        $data = explode('.', $value);
                        $type = end($data);
                        if ($type == 'zip' || $type == 'ZIP') {
                            $gettype[] = $value;
                        }
                    }
                }
                $countfile = count($gettype);
                if ($countfile > 0) {
                    if ($countfile == 1) {
                        echo 'You select ' . $countfile . ' zip file.';
                        echo '------';
                        echo 'successfully';
                        echo '------';
                        echo json_encode($gettype);
                    } else {
                        echo 'You select ' . $countfile . ' zip files.';
                        echo '------';
                        echo 'successfully';
                        echo '------';
                        echo json_encode($gettype);
                    }
                } else {
                    $msg = 'Please select zip file';
                }
            }
        }
        if (empty($msg) === false) {
            echo $msg;
            $msg = '';
        }
    }
}

//**********************************
// After validation zip file extract it
//**********************************

function zip_extract_file()
{
    if (empty($_POST) === false) {
        $zipper   = new Zipclass();
        $arrfile  = $_POST['arrfile'];
        $arrfile  = json_decode($arrfile);
        $root     = $_SERVER['DOCUMENT_ROOT'] . '/';
        $location = $_POST['location'];
        $error_ck = false;
        $msg      = '';
        if (empty($arrfile) === false && isset($arrfile) === true) {
            $error_ck = true;
        }
        if ($error_ck === true) {
            if (is_array($arrfile)) {
                foreach ($arrfile as $file) {
                    if (file_exists($file)) {
                        if ($zipper->zip_extract($file, $root . $location) === false) {
                            echo 'Opss something is wrong!';
                        } else {
                            $msg = 'successfully';
                        }
                    }
                }
            }
        } else {
            echo 'Invalid location';
        }
        
        if (empty($msg) === false) {
            echo $msg;
            $msg = '';
        }
    }
}

//**********************************
// Create new folder using opject
//**********************************

function create_new_directory(){
   if (empty($_POST) === false) {
        $manager = new Managefile();
        $realpath   = $_POST['realpath'];
        $name       = $_POST['name'];
        if (isset($name) && isset($realpath)) {
            echo ($manager->create_folder("$realpath/$name") === true)? 'successfully': 'Opss something is wrong!' ;
        }
   }
}

//**********************************
// Create new file using opject
//**********************************

function create_new_file(){
   if (empty($_POST) === false) {
        $manager = new Managefile();
        $realpath   = $_POST['realpath'];
        $name       = $_POST['name'];
        if (isset($name) && isset($realpath)) {
            if (!file_exists("$realpath/$name")) {
                $manager->create_file("$realpath/$name");
                echo 'File create successfully';
            }else{
                echo 'File allready exists';
            }
            
        }
   }
}

?>