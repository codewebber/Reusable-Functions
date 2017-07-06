<?php
	namespace App\Controller\Component;

	use Cake\Controller\Component;
	use Cake\Controller\ComponentRegistry;
	
class FileComponent extends Component {

    public $allowed_ext = array('*');
    public $min_filesize = 1024;
    public $max_filesize = 104857600;

    /**	
	* uploads files to the server
	 * @params:
	 * $source 	    = temporary file name
	 * $targetdir 	= target directory path
	 * $targetfile 	= original file name
	 * @return:
	 * will return an array with the success of each file upload
    */

    public function upload($source, $targetdir, $targetfile,$type_image) {  
        $filesize  = filesize($source);
        if(($filesize < $this->min_filesize) || ($filesize > $this->max_filesize)) {
            return 'Document filesize must be between ' . $this->human_filesize($this->min_filesize) . ' and ' . $this->human_filesize($this->max_filesize);
        }

        $data = filesize($source);
		$ext = pathinfo($targetfile, PATHINFO_EXTENSION);
       /* if (!in_array($ext, $this->allowed_ext)) {
        	
        	return 'Document filetype not allowed.';
        }*/
        //$this->mkdir($targetdir);
        
		/********************/
		if($type_image == "image")
		{
			$data = getimagesize($source);
			
			if (empty($data) || !is_array($data)) {
				return __('Image is invalid');
			}
			
			list($srcWidth, $srcHeight, $type) = $data;
			
			if (!$srcWidth || !$srcHeight) {
				return __('Image size invalid');
			}
			
			if ($srcWidth < 100 || $srcHeight < 100) {
				return __('Image size must be at least 100x100');
			}
				
		}
		/********************/
		
        if (!file_exists($targetdir)) {
    		mkdir($targetdir, 0777, true);
		}
        if(move_uploaded_file($source, $targetdir.'/'.$targetfile)) {
            return 'Success';
        }
        if(!is_writeable($targetdir.'/'.$targetfile))
        {
        	return "Cannot write to destination file";
        }
        return 'Document upload is invalid';
        //return PHP_EOL;
    }

////////////////////////////////////////////////////////////

    public function human_filesize($bytes, $decimals = 0) {
        $sz 	= 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1000, $factor)) . @$sz[$factor] . 'B';
    }

////////////////////////////////////////////////////////////

    public function ext($file) {
        return mb_strtolower(trim(mb_strrchr($file, '.'), '.'));
    }

////////////////////////////////////////////////////////////

    public function mkdir($targetdir) {
        if(!is_dir($targetdir)) {
            App::uses('Folder', 'Utility');
            $dir = new Folder($targetdir, true, 0777);
            if(!$dir) {
                return false;
            }
        }
        return true;
    }

////////////////////custom addded by siddharth////////////////

    public function docValidate($source, $targetfile) {
    	
    	$ext = pathinfo($targetfile, PATHINFO_EXTENSION);
    	
    	if (!in_array($ext, $this->allowed_ext)) {
    		return 'Document filetype not allowed.';
    	}
    	
    	/*$filesize  = filesize($source);
    	if(($filesize < $this->min_filesize) || ($filesize > $this->max_filesize)) {
    		return 'Document filesize must be between ' . $this->human_filesize($this->min_filesize) . ' and ' . $this->human_filesize($this->max_filesize);
    	}*/
    	
    	return 'Success';
    }

}