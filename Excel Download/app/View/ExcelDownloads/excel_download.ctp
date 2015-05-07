<?php
  /**
   * Export all member records in .xls format
   * with the help of the xlsHelper
   */
  $xls= new xlsHelper();
 
  //input the export file name
  $xls->setHeader('Report_'.date('Y_m_d'));
 
  $xls->addXmlHeader();
  $xls->setWorkSheetName('Data Report');
   
  //1st row for columns name
  $xls->openRow();
  $xls->writeString('ID');
  $xls->writeString('Name');
  $xls->closeRow();
  
  
  foreach($final as $value):
    $xls->openRow();
    $xls->writeString($value['ID']); 
    $xls->writeString($value['Name']);
    $xls->closeRow();
   
  endforeach;  
   
    
    
    
  $xls->addXmlFooter();
  exit();
?>
