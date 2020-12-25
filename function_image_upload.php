<?php
// function_image_upload.php - Upload Image Function 
// Written by: Luis Fuentes, Dec 2020

function image_upload($name, $maxsize, $extns, $dir, $file) {
	$savefile = $msg = NULL; 
// Upload Image
	if (isset($_FILES[$name]['tmp_name'])) {
		$fn = $_FILES[$name]['name'];
		$ext = trim(strtolower(strrchr($fn, '.')));	

// Check for Valid Extention		
		if (!in_array($ext, $extns)) $msg = "Invalid File Type"; 
		
// Check for File Size
		$size = $_FILES[$name]['size'];
		if ($size > $maxsize) $msg = "File exceeds maximum [$maxsize] size [$size]"; 

// Save the Uploaded File
		if ($msg == NULL) {
			$savefile = "$dir/$file$ext";
			$result = move_uploaded_file($_FILES[$name]['tmp_name'], $savefile);
			if (!$result) {$savefile = NULL; $msg = "RESULT [$result]<br>";} 
			$msg = "File successfully Uploaded"; 
			}
		}
	else $msg = "Upload an Image File"; 
	return(array($savefile, $msg)); 
	}	
?>