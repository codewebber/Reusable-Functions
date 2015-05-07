<?php 
App::import('Vendor','xtcpdf');  
App::import('Vendor','class.bargraph');

  
$tcpdf = new XTCPDF();
$tcpdf->SetPrintHeader(false);
//$tcpdf->SetPrintFooter(false);  
$tcpdf->AddPage(); 

foreach($final as $key=>$value):
 	  $data.='<tr>
			    <td class ="taskdata1 tdstyle1 text_align" style="text-indent:5px;">'.$key.'</td>
			    <td class ="taskdata1 tdstyle1" style="text-indent:6px;">'.$value.'</td>
			 </tr>';
	
	endforeach;

	
$html = <<<EOD
<style>

  .headerRow{background-color:#e6e6db;border:1px solid #FFF;}
  .tname{color:#0f6082;font-family:Arial;font-weight:Bold;width:300px;height:30px;}
  .totalTask{color:#696969;width:}
  th{
    color: #505050;
    background-color : #e6e6db;
    height: 18px;
    font-family: times;
    font-size: 12pt;
    text-decoration: none;
    border-bottom : 0.5px solid #cfcfc4;
     
  }
  
  p {
    color: red;
    font-family: helvetica;
    font-size: 12pt;
  }
  .tech_name1 {
  	background: none repeat scroll 0 0 #e6e6db;
    float: left;
    font-weight:bold;
  }
  .taskdata1 {
  	background: none repeat scroll 0 0 #e6e6db;
    border : 0.5px solid #e6e6db;
    float: left;
    height: 2px;
    line-height:2px;
    font-family: times;
    font-size: 12pt;
    text-decoration: none;
    border-bottom: 1px solid #cfcfc4;
  }
  .text_align{
  	text-align:center;
  }
  .tdstyle1{
  	background-color:#e6e6db;
    //border-bottom: 1px solid #E8ECEB;
  }
  .txt_id{
  	text-indent:5px;
  }
</style>
 
	

<table  cellpadding="0">
	
  <tr>
    <th class ="tech_name1 txt_id text_align" style="width:23px;">&nbsp;&nbsp;Id</th>
    <th class ="tech_name1 " style="width:100px;">&nbsp;&nbsp;Name</th>
    
  </tr>
  
  $Data
 
</table>
 
EOD;
 

$tcpdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);  

$tmp = "PATH";
$tcpdf->Output($tmp."pdf_name.pdf", 'F'); 

?>

<div>
