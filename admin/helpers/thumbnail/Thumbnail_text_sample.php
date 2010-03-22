<?php
//Thumbnail sample
include ('Thumbnail.class.php');

$thumb=new Thumbnail("source.jpg");	        // Contructor and set source image file

$thumb->size_auto(300);					    // [OPTIONAL] set the biggest width or height for thumbnail

$thumb->txt_watermark_Hmargin=10;           // [OPTIONAL] set watermark text horizonatal margin in pixels
$thumb->txt_watermark_Vmargin=10;           // [OPTIONAL] set watermark text vertical margin in pixels

$thumb->txt_watermark='Font 1';	    // [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_color='FF0000';	    // [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_font=1;	            // [OPTIONAL] set watermark text font: 1,2,3,4,5
$thumb->txt_watermark_Valing='TOP';   	// [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
$thumb->txt_watermark_Haling='LEFT';       // [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
$thumb->process();   				        // generate image

$thumb->txt_watermark='Font 2';	    // [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_color='FFFFFF';	    // [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_font=5;	            // [OPTIONAL] set watermark text font: 1,2,3,4,5
$thumb->txt_watermark_Valing='TOP';   	// [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
$thumb->txt_watermark_Haling='RIGHT';       // [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
$thumb->process();   				        // generate image

$thumb->txt_watermark='Font 3';	    // [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_color='0000FF';	    // [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_font=3;	            // [OPTIONAL] set watermark text font: 1,2,3,4,5
$thumb->txt_watermark_Valing='CENTER';   	// [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
$thumb->txt_watermark_Haling='CENTER';       // [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
$thumb->process();   				        // generate image

$thumb->txt_watermark='Font 4';	    // [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_color='000000';	    // [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_font=4;	            // [OPTIONAL] set watermark text font: 1,2,3,4,5
$thumb->txt_watermark_Valing='BOTTOM';   	// [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
$thumb->txt_watermark_Haling='LEFT';       // [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
$thumb->process();   				        // generate image

$thumb->txt_watermark='Font 5';	    // [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_color='00FF00';	    // [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_font=5;	            // [OPTIONAL] set watermark text font: 1,2,3,4,5
$thumb->txt_watermark_Valing='BOTTOM';   	// [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
$thumb->txt_watermark_Haling='RIGHT';       // [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
$thumb->process();   				        // generate image

$thumb->show();						        // show your thumbnail, or
//$thumb->save("thumbnail.jpg");			// save your thumbnail to file, or
//$image = $thumb->dump();                  // get the image

//echo ($thumb->error_msg);                 // print Error Mensage
?>