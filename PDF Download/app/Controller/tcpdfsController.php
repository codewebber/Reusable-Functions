<?php 
	function tcpdf_view(){
		$final=$this->Model->find('all');
		$this->set(compact('final'));
				
		$this->layout = 'pdf';  
		$this->render();   
		$path="PATH";
		     
		$file = $path.'pdf_name.pdf';
		$content = chunk_split(base64_encode(file_get_contents($file)));
		ob_start();
		$uid = md5(uniqid(time()));
		$name = basename($file);
	}
?>
