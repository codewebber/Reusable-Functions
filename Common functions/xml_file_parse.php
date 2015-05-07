<?php
/**** Read/Parse the date from XML file(uploaded to server)  *****/
App::uses('Xml', 'Utility');

	function xml_file_parse($file){
	   $xml = new Xml($file);
	   $xmlArray = Xml::toArray(Xml::build($file));

	}
?>
