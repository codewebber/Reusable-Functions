<?php 
/**
* property Adding custom fields of different models
* mandatory data   pass the model name from form submit.
*                  form name : CustomField
*                  hidden field name : module
* model functions  updateField($data),getFieldByName($data),addField($data)
*/
public function add() { 
	if ($this->request->is('post')) {
    		if($this->data['CustomField']['module']){
    			$module = $this->data['CustomField']['module'];
    			$this->loadModel($module);
			foreach($this->data['CustomField']['fieldOld'] as $keyOld=>$valOld) { 
				if($valOld){
					$dataUpdate['id']			=	$keyOld;
					$dataUpdate['sbs_subscriber_id']	=	$this->subscriber;
					$dataUpdate['field_name']		=	$valOld;
					$addCustomField = $this->$module->updateField($dataUpdate);
				}else{
					if(count($this->data['CustomField']['field']) >1){
						$this->$module->id = $keyOld;
						$this->$module->delete();
					}
				}
			}  
			foreach($this->data['CustomField']['field'] as $key=>$val) { 
				if($val){
					$customFieldExist = $this->$module->getFieldByName(trim($val),$this->subscriber);
					if($customFieldExist){
						$duplicateEntry = 1;
					}else{
						$dataAdd['sbs_subscriber_id']	=	$this->subscriber;
						$dataAdd['field_name']		=	$val;
						$addCustomField = $this->$module->addField($dataAdd);
					}
				}
			}  
			if($duplicateEntry){
			$this->Session->setFlash('<div class="alert alert-danger">Duplicate field name entered.</div>');
			}
			if($addCustomField) {
			  if($duplicateEntry) {
			    $this->Session->setFlash('<div class="alert alert-danger">Duplicate field name entered.</div>');
			  }else{
			    $this->Session->setFlash(__('<div class="alert alert-block alert-success">Custom Fields added.</div>'));
			}
		}else{
			$this->Session->setFlash('<div class="alert alert-danger">Sorry!Mandatory field cannot be left empty.</div>');
}else{
    $this->Session->setFlash('<div class="alert alert-danger">Sorry! There are no module selected.</div>');
    }
   return $this->redirect(array('action' => 'add'));
}	
}
?>
