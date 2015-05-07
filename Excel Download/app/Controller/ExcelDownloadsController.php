<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class ExcelDownloadsController extends AppController {

	 var $helpers = array('Xls');

	  public function excel_download() {
	    $final=$this->Model->find('all');
	    $this->set(compact('final'));
	  }

	
		
}?>
