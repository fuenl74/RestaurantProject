<?php
// image_resize.php - Resize an image smaller proportionally
// Written by: Luis Fuentes, Dec 2020

// Inputs - 3 parameters
//	1) fully qualified image name (from the website root directory), ie. images/picture.jpg
//	2) The maximum width of the resized image
//	3) The maximum height of the resized image
	
// Outputs - array with three elements
//	1) TRUE 			or 		FALSE 			Resize Success or Failure
//	2) resized width	or 		ERROR MESSAGE
//	3) resized height	or		NULL 
	
function image_resize($pic, $width, $height) {
	$msg	= NULL;	
	if (is_file($pic)) {
		if (!is_dir($pic)) {
			$size = getimagesize($pic);
			if ($size[0] == 0) 	$neww = $width; 	else $neww = $size[0];
			if ($size[1] == 0)	$newh = $height;	else $newh = $size[1];
			$ratio = $neww/$newh;
			if ($neww > $width) {
				$neww = $width; 
				$newh = round($neww / $ratio);
				}
			if ($newh > $height) {
				$newh = $height; 
				$neww = round($newh * $ratio);
				}
			}
		else $msg = "Image file is a directory";
		}
	else $msg = "Image file not found";
	if ($msg == NULL) 
		return(array(TRUE, $neww, $newh));
	else return(array(FALSE, $msg, NULL));
	}
?>