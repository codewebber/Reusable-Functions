<?php

App::uses('AppController', 'Controller');


class Controller extends AppController {
	
    public $components = array('RequestHandler'); 

    function LineGraph($totalSaleArr, $amountRecievedArr, $divisor) {
		
	App::import('Vendor', 'jpgraph/jpgraph');
        App::import('Vendor', 'jpgraph/jpgraph_line');
        App::import('Vendor', 'jpgraph/jpgraph_scatter');
    
	$datay1 = $amountRecievedArr;
	$datay2 = $totalSaleArr;	
     
	// Setup the graph
	$graph = new Graph(600,250,'auto',1);
	$graph->SetScale("textlin");
	$graph->SetMargin(75,16,15,10);	
	$gDateLocale = new DateLocale();
	$months = $gDateLocale->GetShortMonth();	
	$financialYear = $this->getFinancialYear();
	$startYear = $financialYear['start_year'];
	$endYear   = $financialYear['end_year'];
	$months = array_merge(array_slice($months,$startYear-1,12-($startYear-1)), array_slice($months,0,$startYear-1));
	$graph->SetBox(true);
	$graph->SetBox(false);
	$graph->ygrid->SetFill(false);	
	$graph->SetBox(false);
	$graph->yaxis->HideLine(true);
	$graph->yaxis->HideZeroLabel();
	$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
	$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
	if($divisor == 1){$graph->yaxis->SetLabelFormat('%s');}
	else {$graph->yaxis->SetLabelFormat('%s M');}	
	$graph->xaxis->SetTickLabels($months);
	$graph->img->SetAntiAliasing(false);
	// Create the plot
	$p1 = new LinePlot($datay1);
	$graph->Add($p1);
	
	$p2 = new LinePlot($datay2);
	$graph->Add($p2);
	

	// Use an image of favourite car as marker
	$p1->mark->SetType(MARK_IMG_SBALL,'green');
	$p1->SetLegend('Amount Recieved');
	$p1->SetColor('#3E8B3E');
	$p1->SetWeight(2);
	$p1->value->SetFormat('%.2f');
	$p1->value->Show();
	$p1->value->SetColor('#3E8B3E');	
		
	$p2->mark->SetType(MARK_IMG_SBALL,'red');
	$p2->SetLegend('Amount Invoiced');
	$p2->SetColor('#D72727');
	$p2->SetWeight(2);
	$p2->value->SetFormat('%.2f');
	$p2->value->Show();
	$p2->value->SetColor('#D72727');
	
	$graph->legend->SetAbsPos(30,220,"right", "top");
	$graph->legend->SetFont(FF_FONT1,FS_BOLD);
	$graph->legend->SetColor('#4E4E4E');
	// Output line
	
	// Get the handler to prevent the library from sending the
       // image to the browser
      $gdImgHandler = $graph->Stroke(_IMG_HANDLER);
      // Stroke image to a file
      // Default is PNG so use ".png" as suffix
      $fileName = "invoicesline.png";
      $graph->img->Stream($fileName);
  }

}

?>
