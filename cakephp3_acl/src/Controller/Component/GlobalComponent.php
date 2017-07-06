<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class GlobalComponent extends Component {
	
	public function changeStatus()
	{
		$this->ModelName = TableRegistry::init('Bookmarks');
		echo "hi";exit;
	}
	
}

?>