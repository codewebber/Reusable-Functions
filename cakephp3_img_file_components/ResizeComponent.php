<?php

namespace App\Controller\Component;
use Cake\Controller\Component;


class ResizeComponent extends Component {

public function resize($file_type, $file_name, $file_size, $file_tmp){
ob_start();
	$path_thumbs_small 	= $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/small';
	$path_thumbs_medium = $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/medium';
	$path_thumbs_big 	  =   $_SERVER['DOCUMENT_ROOT'] . $this->request->webroot.'webroot/uploads/big';

	$img_thumb_width_medium = 100; // 
  $img_thumb_width_big 	= 200; // 
  $img_thumb_width_small 	= 50; //

	$extlimit = "yes"; //Limit allowed extensions? (no for all extensions allowed)
		//List of allowed extensions if extlimit = yes
	$limitedext = array(".gif",".jpg",".png",".jpeg",".bmp");

		//check if you have selected a file.
        if(!is_uploaded_file($file_tmp)){
          return false;
        }

        //so, whats the file's extension?
       $getExt = explode ('.', $file_name);
       $file_ext = $getExt[count($getExt)-1];

       //create a random file name
       $rand_name = md5(time());
       $rand_name= rand(0,999999999);

       //the new width variable
       $ThumbWidth_medium = $img_thumb_width_medium;
       $ThumbWidth_big = $img_thumb_width_big;
       $ThumbWidth_small = $img_thumb_width_small;


       //////////////////////////
	   // CREATE THE THUMBNAIL //
	   //////////////////////////
	   
       //keep image type
       if($file_size){
          if($file_type == "image/pjpeg" || $file_type == "image/jpeg"){
               $new_img = imagecreatefromjpeg($file_tmp);
           }elseif($file_type == "image/x-png" || $file_type == "image/png"){
               $new_img = imagecreatefrompng($file_tmp);
           }elseif($file_type == "image/gif"){
               $new_img = imagecreatefromgif($file_tmp);
           }
           //list the width and height and keep the height ratio.
           list($width, $height) = getimagesize($file_tmp);
           //calculate the image ratio
           $imgratio=$width/$height;
           if ($imgratio>1){
              $newwidth_medium = $ThumbWidth_medium;
              $newheight_medium = $ThumbWidth_medium/$imgratio;

              $newwidth_small = $ThumbWidth_small;
              $newheight_small = $ThumbWidth_small/$imgratio;

              $newwidth_big = $ThumbWidth_big;
              $newheight_big = $ThumbWidth_big/$imgratio;

           }else{
                 $newheight_medium = $ThumbWidth_medium;
                 $newwidth_medium = $ThumbWidth_medium*$imgratio;

                 $newheight_small = $ThumbWidth_small;
                 $newwidth_small = $ThumbWidth_small*$imgratio;

                 $newheight_big = $ThumbWidth_big;
                 $newwidth_big = $ThumbWidth_big*$imgratio;
           }
           //function for resize image.
           if (function_exists(@imagecreatetruecolor)){
           $resized_img_medium = imagecreatetruecolor($newwidth_medium,$newheight_medium);
           $resized_img_small = imagecreatetruecolor($newwidth_small,$newheight_small);
           $resized_img_big = imagecreatetruecolor($newwidth_big,$newheight_big);
           }else{
                 die("Error: Please make sure you have GD library ver 2+");
           }
           //the resizing is going on here!
           imagecopyresized($resized_img_medium, $new_img, 0, 0, 0, 0, $newwidth_medium, $newheight_medium, $width, $height);
           imagecopyresized($resized_img_small, $new_img, 0, 0, 0, 0, $newwidth_small, $newheight_small, $width, $height);
           imagecopyresized($resized_img_big, $new_img, 0, 0, 0, 0, $newwidth_big, $newheight_big, $width, $height);
           //finally, save the image
           ImageJpeg ($resized_img_medium,"$path_thumbs_medium/$rand_name.$file_ext");
           ImageDestroy ($resized_img_medium);
          // ImageDestroy ($new_img);

           ImageJpeg ($resized_img_small,"$path_thumbs_small/$rand_name.$file_ext");
           ImageDestroy ($resized_img_small);
         //  ImageDestroy ($new_img);

           ImageJpeg ($resized_img_big,"$path_thumbs_big/$rand_name.$file_ext");
           ImageDestroy ($resized_img_big);
           ImageDestroy ($new_img);
           
        }

        if(@move_uploaded_file ($file_tmp, "$path_thumbs_medium/$rand_name.$file_ext")){
        	return true;
        }else{
        	return false;
        }

        move_uploaded_file ($file_tmp, "$path_thumbs_small/$rand_name.$file_ext");
        move_uploaded_file ($file_tmp, "$path_thumbs_big/$rand_name.$file_ext");

	}
}

?>