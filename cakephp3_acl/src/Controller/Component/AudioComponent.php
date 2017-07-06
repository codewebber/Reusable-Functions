<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class AudioComponent extends Component {
    public $allowed_ext = array('mp3','mp2','ogg','wav','3gp','aa','aac','aax','act','aiff','amr','ape','au','awb','dct','dss','dvf','flac','gsm','ivs','m4a','m4b','m4p','mmf','mpc','msv','oga','mogg','opus','ra','rm','raw','sln','tta','vox','wma','wv','webm');
    public $min_filesize = 1000;
    public $max_filesize = 10000000;

    /**	
	* uploads files to the server
	 * @params:
	 * $source 	    = temporary file name
	 * $targetdir 	= target directory path
	 * $targetfile 	= original file name
	 * @return:
	 * will return an array with the success of each file upload
    */

    public function upload($source, $targetdir, $targetfile) {    	
    	
        $filesize  = filesize($source);
        if(($filesize < $this->min_filesize) || ($filesize > $this->max_filesize)) {
            return __('Document filesize must be between ' . $this->human_filesize($this->min_filesize) . ' and ' . $this->human_filesize($this->max_filesize));
        }

        $data = filesize($source);
		$ext = pathinfo($targetfile, PATHINFO_EXTENSION);
        if (!in_array($ext, $this->allowed_ext)) {
            return 'Document filetype not allowed.';
        }
        //$this->mkdir($targetdir);
        if (!file_exists($targetdir)) {
    		mkdir($targetdir, 0777, true);
		}
        if(move_uploaded_file($source, $targetdir.'/'.$targetfile)) {
            return 'Success';
        }
	
        return 'Document upload is invalid';
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
    	
    	$filesize  = filesize($source);
    	if(($filesize < $this->min_filesize) || ($filesize > $this->max_filesize)) {
    		return 'Document filesize must be between ' . $this->human_filesize($this->min_filesize) . ' and ' . $this->human_filesize($this->max_filesize);
    	}
    	
    	return 'Success';
    }

}
?>