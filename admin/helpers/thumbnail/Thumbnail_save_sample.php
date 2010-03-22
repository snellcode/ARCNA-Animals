<?php
//Thumbnail sample: generate thumbnail + watermark and save to a file with a unique filename

include ('Thumbnail.class.php');

$thumb=new Thumbnail("source.jpg");	        // Contructor and set source image file
$thumb->img_watermark='watermark.png';	    // [OPTIONAL] set watermark source file, only PNG format [RECOMENDED ONLY WITH GD 2 ]
$thumb->size(150,113);		                // [OPTIONAL] set the biggest width and height for thumbnail
$thumb->process();   				        // generate image
$filename=$thumb->unique_filename ( '.' , 'sample.jpg' , 'thumb');  // generate unique filename
$status=$thumb->save($filename);            // save your thumbnail to file
if ($status) {
    echo('Thumbnail save as '.$filename);
} else {
    echo('ERROR: '.$thumb->error_msg);
}
?>