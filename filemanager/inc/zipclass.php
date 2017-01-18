<?php

//**********************************
// Zip class
//**********************************
class Zipclass
{
    private $_files = array();
    private $_zip;
    
    function __construct()
    {
        $this->_zip = new ZipArchive();
    }
    
    //**********************************
    // Add zip files
    //**********************************
    
    public function add($input)
    {
        if (is_array($input)) {
            $this->_files = array_merge($this->_files, $input);
        } else {
            $this->_files[] = $input;
        }
    }
    
    //**********************************
    // Create zip
    //**********************************
    
    public function zip_create($localtion = null)
    {
        if (count($this->_files) && $localtion) {
            foreach ($this->_files as $index => $file) {
                if (!file_exists($file)) {
                    unset($this->_files[$index]);
                }
            }
            if ($this->_zip->open($localtion, file_exists($localtion) ? ZipArchive::OVERWRITE : ZipArchive::CREATE)) {
                foreach ($this->_files as $index => $file) {
                    $data    = explode('/', $file);
                    $newname = end($data);
                    if (is_file($file)) {
                        $this->_zip->addFile($file, $newname);
                    } else {
                        //inclide function for folder
                        $this->add_folder($file);
                    }
                }
            }
            $this->_zip->close();
        }
    }
    
    //**********************************
    // Add folder for zip
    //**********************************
    
    public function add_folder($rootPath) // this function for zip create
    {
        $rootPath = realpath($rootPath);
        $files    = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir()) {
                // Get real and relative path for current file
                $filePath     = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                
                // Add current file to archive
                $this->_zip->addFile($filePath, $relativePath);
            }
        }
    }
    
    //**********************************
    // Extract form zip file
    //**********************************
    
    public function zip_extract($open, $ext_location)
    {
        //$open which file you want to open it
        //$ext_location which location you want to extract it
        if (!file_exists($open)) {
            @mkdir($open);
            if ($this->_zip->open($open) === TRUE) {
                $this->_zip->extractTo($ext_location);
                $this->_zip->close();
                return true;                
            } else {
                return false;
            }
        }else{
            if ($this->_zip->open($open) === TRUE) {
                $this->_zip->extractTo($ext_location);
                $this->_zip->close();
                return true;                
            } else {
                return false;
            }
        }
    }
    
} //End class

?>