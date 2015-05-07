<?php
App::uses('AppController', 'Controller');

class Controller extends AppController {

  var $helpers = array('Xls');

  public function excel_data() {
    $final=$this->Model->find('all');
    $this->set(compact('final'));
  }


} ?>
