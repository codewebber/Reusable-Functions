<?php
App::uses('AppController', 'Controller');

class Controller extends AppController {
	
    public $components = array('Ofc','RequestHandler'); 



   public function piechart(){
	
        $data1= array('10','20','30','40','50');
        $data2= array('IE','Firefox','Opera','Wii','Other');

	//pie chart
	$swfwidth = '100%';
	$this->Ofc->set_ofc_webroot($this->webroot);
	$this->Ofc->set_ofc_size($swfwidth,300);

	$this->Ofc->init();
	$this->Ofc->setup();
	$this->Ofc->set_ofc_data($data1);
	$this->Ofc->pie(90,'#505050','{font-size: 10px; color:#000000;font-weight:bold;');
	$this->Ofc->pie_values($data2); 
	$this->Ofc->pie_slice_colors(array('#ec282c','#38943d','#25a2dc','#EDEF3B','#6119E8','#4F4E3C') );
	$graph=$this->Ofc->ofc_render();
        $this->set(compact('graph'));
			
  }
	

}

?>
