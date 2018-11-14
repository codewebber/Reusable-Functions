<?php
// directory path from where the html files to be read
$dir   = 'file:///home/siddharth/sidharth/';
// scan in ascending order
$files = scandir($dir);

// scan in descending order
// $files = scandir($dir, 1);

// serial number
$sn = 1;
// generated and stored csv in the below path
$output_file_name = '/var/www/html/webscrape/uploads/company_data.csv';
$output_file = fopen($output_file_name, 'w');

$column_headings = array('SN','Company Name', 'Website', 'CIN', 'Authorized Capital', 'Company Category',
'Company Subcategory', 'Email Address', 'Incorporation Date', 'Paid-up Capital', 'Registered Address',
'Company Status', 'Company Class', 'Is Company Listed', 'Last Board Meeting On', 'Last Balance Sheet On', 'Number of Members',
'Secondary Address', 'ROC where registered', 'Exchange at which suspended');

fputcsv($output_file, $column_headings);

foreach ($files as $filenames)
{	
	// check if file is directory
	if (is_dir($dir.$filenames)) {
		
	} else {
		$filename = $dir.$filenames;
		$fh = fopen($filename, 'r');
		$cont = fread($fh, filesize($filename));

		$cell = array();		
		
		preg_match_all('#<table[^>]*>(.*?)</table[^>]*>#is', $cont, $t_matches, PREG_PATTERN_ORDER);		

		// now we have the data from each table in $t_matches[1]
		foreach ($t_matches[1] as $tablestring){
		      preg_match_all('#<tr[^>]*>(.*?)</tr[^>]*>#is', $tablestring, $tr_matches, PREG_PATTERN_ORDER);

		      // now we have each row in the table $tr_matches[1];
		      foreach($tr_matches[1] as $rowstring){
			 preg_match_all('#<td[^>]*>(.*?)</td[^>]*>#is', $rowstring, $td_matches, PREG_PATTERN_ORDER);

			 // and now we have each table cell in the row in $td_matches[1]
			foreach($td_matches[1] as $cellstring){
			      $cell[] = trim($cellstring);			      
			} 			
		      }		 
		}
		$astring = $cell[1];
		if ($astring && $astring != '-') {
			// extract href value in anchor tag
			$anchor = new SimpleXMLElement($astring);
			$cell[1] = $anchor['href'];
		}
		$data_array = array (
			$sn,
			$cell[0],
			$cell[1],
			$cell[2],
			$cell[3],
			$cell[4],
			$cell[5],
			$cell[6],
			$cell[7],
			$cell[8],
			$cell[9],
			$cell[10],
			$cell[11],
			$cell[12],
			$cell[13],
			$cell[14],
			$cell[15],
			$cell[16],
			$cell[17],
			$cell[18]
		);
		fputcsv($output_file, $data_array);
		$sn++;	
	}	
}
fclose($output_file);
?>

