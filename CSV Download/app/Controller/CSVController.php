<?php
App::uses('AppController', 'Controller');
CakePlugin::load('Uploader');
CakePlugin::load('Export'); 
App::import('Vendor', 'Uploader.Uploader');


class Controller extends AppController {

   var $components = array('Export.Export', 'Auth', 'Session', 'Cookie', 'RequestHandler', 'Security');

   public function export_data() {
	$data = $this->Model->find('all');
	$this->Export->exportCsv($data, 'file.csv');
	// a CSV file called file.csv will be downloaded by the browser.
   }

}


?>
