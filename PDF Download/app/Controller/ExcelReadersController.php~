<?php

//Impot excel reader vender 
App::import('Vendor', 'php-excel-reader/excel_reader2');
class ExcellReadersController extends AppController {
	
	function show_excel() {
	
		if(($_FILES['file']['type'] == 'application/vnd.ms-excel') || (($_FILES['file']['type'] == 'application/octet-stream'))){
			$fileOK = $this->uploadFiles('files', $_FILES);
			if($fileOK['urls']['0']){
	   			/*$excel = new PhpExcelReader;*/
	   			$excel = new Spreadsheet_Excel_Reader;
	   			$excel->read($fileOK['urls']['0']);
	   			/*$nr_sheets = count($excel->sheets);*/
	   			$excel_data = '';
	   			
	   			if($excel->boundsheets['0']['name'] == 'Data'){
	   				// traverses the number of sheets and sets html table with each sheet data in $excel_data
					$excel_data =  $this->sheetData($excel->sheets['0'],$excel->boundsheets['0']['name']) ;  
					$saveData['Data'] = $excel_data;
		 		 	if($saveData){
						echo 'Success';
					}
	   			}else{
	   				echo 'failure';
	   			}
	   			
	   		}else{
	   			echo 'Data import failed.Please save the excel with .xls';
	  		}
		}elseif(($_FILES['file']['type']) && ($_FILES['file']['type'] != 'application/vnd.ms-excel')){
			echo 'File you tried to import is invalid';
		}
		$documentPath = WWW_ROOT.$fileOK['urls']['0'];
		unlink($documentPath);
	}
}
