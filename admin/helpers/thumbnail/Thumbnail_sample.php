<?php
//Thumbnail sample
include ('Thumbnail.class.php');

$thumb=new Thumbnail("source.jpg");	        // Contructor and set source image file

//$thumb->memory_limit='32M';               //[OPTIONAL] set maximun memory usage, default 32 MB ('32M'). (use '16M' or '32M' for litter images)
//$thumb->max_execution_time='30';             //[OPTIONAL] set maximun execution time, default 30 seconds ('30'). (use '60' for big images o slow server)

/*
$thumb->quality=85;                         // [OPTIONAL] default 75 , only for JPG format
$thumb->output_format='JPG';                // [OPTIONAL] JPG | PNG
$thumb->jpeg_progressive=0;               // [OPTIONAL] set progressive JPEG : 0 = no , 1 = yes
$thumb->allow_enlarge=false;              // [OPTIONAL] allow to enlarge the thumbnail
//$thumb->CalculateQFactor(10000);          // [OPTIONAL] Calculate JPEG quality factor for a specific size in bytes
//$thumb->bicubic_resample=false;             // [OPTIONAL] set resample algorithm to bicubic
*/

$thumb->img_watermark='watermark.png';	    // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]

/*
$thumb->img_watermark_Valing='TOP';   	    // [OPTIONAL] set watermark vertical position, TOP | CENTER | BOTTON
$thumb->img_watermark_Haling='LEFT';   	    // [OPTIONAL] set watermark horizonatal position, LEFT | CENTER | RIGHT

$thumb->txt_watermark='Watermark Text';	    // [OPTIONAL] set watermark text [RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_color='FF0000';	    // [OPTIONAL] set watermark text color , RGB Hexadecimal[RECOMENDED ONLY WITH GD 2 ]
$thumb->txt_watermark_font=5;	            // [OPTIONAL] set watermark text font: 1,2,3,4,5
$thumb->txt_watermark_Valing='BOTTOM';   	// [OPTIONAL] set watermark text vertical position, TOP | CENTER | BOTTOM
$thumb->txt_watermark_Haling='RIGHT';       // [OPTIONAL] set watermark text horizonatal position, LEFT | CENTER | RIGHT
$thumb->txt_watermark_Hmargin=10;           // [OPTIONAL] set watermark text horizonatal margin in pixels
$thumb->txt_watermark_Vmargin=10;           // [OPTIONAL] set watermark text vertical margin in pixels

$thumb->size_width(150);				    // [OPTIONAL] set width for thumbnail, or
$thumb->size_height(113);				    // [OPTIONAL] set height for thumbnail, or
$thumb->size_auto(150);					    // [OPTIONAL] set the biggest width or height for thumbnail
*/

$thumb->size(150,113);		            // [OPTIONAL] set the biggest width and height for thumbnail

$thumb->process();   				        // generate image

$thumb->show();						        // show your thumbnail, or

//$thumb->save("thumbnail.".$thumb->output_format);			// save your thumbnail to file, or
//$image = $thumb->dump();                  // get the image

//echo ($thumb->error_msg);                 // print Error Mensage
?>