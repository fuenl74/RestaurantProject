<?php
// special_update.php - Update the Daily Special
// Written by: Luis Fuentes, Dec 2020

// Includes
	require('xx_mysqli_connect.php');
	require('function_image_upload.php'); 
	require('image_resize.php');	
	require('sanitize.php');
	
// Variables
	$pgm		= 'special_update.php';
	$table		= 'specials'; 
	$bold		= "style='font-weight:bold;'";
	$msg		= NULL;
	$msg_color	= 'black';
	$td1		= "align='right' $bold";
	$td2		= "align='left'";
	$photo		= NULL;
	$font	    = "\"Brush Script MT\""; 
	$imgdir		= 'images';
	$maxsize	= 1024 * 1024;
	$maxw		= 400;
	$maxh		= 400; 
	$imgdir		= 'images'; 
	$background = "$imgdir/special_background2.jpg";
	$extns		= array('.gif', '.jpg', '.jpeg', '.png');	
// Output 
	echo "<!doctype HTML><html><body align='center' style='background-image: url($background);'>
		  <style> 
				p a
				{
					 text-decoration:none;
				}
			  .dropdown-contentt { 
				  color: black;
				  font-weight: bold;
				  font-family: roboto;
				  font-size: 90%;
				  background-color: white;
				  min-width: 100px;
				  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
				  padding: 5px 14px;
				  z-index: 1;				
				}
		  </style>
		  <p style='font-family:$font; font-size:32px; font-weight:bold;'><a href='dailyspecial.php'>Luigi&#039;s Pasta and Pizza </a> "; 
		
	
// Get Input
	if (isset($_POST['task']))		$task   	= $_POST['task'];		else $task		= 'First';
	if (isset($_GET['d']))		{$day = $_GET['d']; $task = 'Show';}	else $day		= NULL;
	if (isset($_POST['day']))		$day 		= $_POST['day'];
	if (isset($_POST['newday']))	$newday		= $_POST['newday'];		else $newday	= NULL;	
	if (isset($_POST['photo']))		$photo 		= $_POST['photo'];		else $photo		= NULL;	
	if (isset($_POST['title']))		$title  	= $_POST['title'];		else $title		= NULL;
	if (isset($_POST['descr']))		$descr  	= $_POST['descr'];		else $descr		= NULL;
	if (isset($_POST['cal']))		$cal  		= $_POST['cal'];		else $cal		= NULL;
	if (isset($_POST['price']))		$price  	= $_POST['price'];		else $price		= NULL;
	if ($day == NULL)				$task 		= 'First'; 
	if ($day == 'New') {$day = NULL; $task 		= 'New'; }
	if ($newday != NULL) $task = 'Add';
//	foreach($_POST as $key => $value) echo "KEY [$key], VALUE [$value]<br>"; 
//	foreach($_FILES['photo'] as $key => $value) echo "KEY [$key], VALUE [$value]<br>"; 	

// Sanitize Input
	if (($task == 'Add') OR ($task == 'Change')) {
		$title = sanitize($mysqli, $title);
		$descr = sanitize($mysqli, $descr);
		$price = sanitize($mysqli, $price);
		}

// Verify Input 
	if (($task == 'Add') OR ($task == 'Change')) {
		if ($title == NULL) $msg .= 'Title is missing<br>';
		if ($descr == NULL) $msg .= 'Descripton is missing<br>';
		if ($price == NULL) $msg .= 'Price is missing<br>';
		if ($cal == NULL) 	$msg .= 'Calories are missing<br>';
		if ($msg != NULL) $task = 'Error';
		}
		
// Process Input
	switch($task) {
	case 'First':	$msg = 'Select a Day';  break;

    case 'Error':	$msg_color = 'red';  break;
	
	case 'New':		$msg ='Enter info and press UPDATE'; break;

	case 'Show':
		$query = "SELECT title, descr, photo, price, calories FROM $table WHERE day = '$day'";
		$result = mysqli_query($mysqli, $query);
		if (!$result) echo "Query failed [$query] – " . mysqli_error($mysqli); 
		if (mysqli_num_rows($result) < 1) {
			$msg = "Day $day not found."; 
			$msg_color='red'; 
			$title = $descr = $photo = $price = $cal = NULL;
			}
		else {
			list($title, $descr, $photo, $price, $cal) = mysqli_fetch_row($result); 
			$msg = "Day $day found";
			} 
		break;

	case 'Add':
		$query = "INSERT INTO $table SET
				  day		= '$newday',
				  title		= '$title',
				  descr		= '$descr',
				  price		= '$price',
				  calories	= '$cal',
				  photo		= '$photo'"; 
		$result = mysqli_query($mysqli, $query);
		if (!$result) {
			$msg = "Query failed [$query]" . mysqli_error($mysqli); 
			$msg_color='red';
			}
		else {
			$msg = "$day Special added";
			}
		break;
    
	case 'Update':
		$query = "UPDATE $table SET
				  title		= '$title',
				  descr		= '$descr',
				  price		= '$price',
				  calories	= '$cal'
				  WHERE day = '$day'";
		$result = mysqli_query($mysqli, $query);
		if (!$result) {
			$msg = "QUERY failed [$query]: " . mysqli_error($mysqli);
			$msg_color = 'red';
			}
		else $msg = "Day $day Updated";
		break;
 
	case 'Remove':
		$query = "DELETE FROM  $table WHERE day = '$day'";
		$result = mysqli_query($mysqli, $query);
		if (!$result) {
			$msg = "QUERY failed [$query]: " . mysqli_error($mysqli);
			$msg_color = 'red';
			}
		else $msg = "Day $day Removed";
		break;
 
	default:
		$msg = "Invalid Task [$task]"; 
    }	
	
// Get Image
	if (($task == 'Add') OR ($task == 'Update')) {
		if (isset($_FILES['photo']['tmp_name'])) {
			list($photo2, $msg2) = image_upload('photo', $maxsize, $extns, $imgdir, $day);
			if ($photo2 != NULL) {
				$query = "UPDATE $table SET photo = '$photo2' WHERE day = '$day'"; 
				$result = mysqli_query($mysqli, $query);
				if (!$result) {
					$msg = "Query failed [$query] ". mysqli_error($mysqli);
					$msg_color = 'red';
					}
				else $photo = $photo2; 
				}
			}
		}	

// Output
	echo "<!doctype HTML><html><body align='center' style = 'margin:auto; width: 80%;'>
		  <script>
		  function ConfirmDelete() {
			  var x = confirm('Are you sure you want to delete?');
			  if (x) return true; else return false;
			  }
		  </script>
		  <section style='margin:auto; width: 70%; background-color: rgba(255, 255, 255, 0.5); font-weight:bold;'>Daily Special Update</section>\n";
		  
// Select a Day Dropdown
	if ($task == 'New')	$se = 'selected';	else $se = NULL;
	echo "<p align='center' $bold>
		  <form action='$pgm' method='post'> 
		  <input type='hidden' name='task' value='Show'>
		  <p style='margin:auto; width: 70%; background-color: rgba(255, 255, 255, 0.5); font-weight:bold;'>Select a Day <select class='dropdown-contentt' name='day' onchange='this.form.submit()'>
		  <option value=''>Select</option><option value='New' $se>** New **</option>\n";
	$query = "SELECT day FROM $table ORDER BY day"; 
	$result = mysqli_query($mysqli, $query);
	while(list($dayx) = mysqli_fetch_row($result)) {
		if ($dayx == $day)	$se = 'selected';	else $se = NULL;
		echo "<option $se>$dayx</option>\n";
		}
	echo "</select></form>\n";
	
// Update Form
	if ($photo == NULL) $photo = 'None'; 
	if ($task == 'New')	$nd = "<tr><td $td1>Day</td>
			  <td $td2><input type='text' name='newday' value='' size='20'></td></tr>";
	else $nd = NULL;
	echo "<p><form action='$pgm' method='post' enctype='multipart/form-data'>
		  <input type='hidden' name='day' value='$day'>
		  <input type='hidden' name='photo' value='$photo'>
		  <table align='center' width='70%' style='background-color: rgba(255, 255, 255, 0.5);'>
		  $nd
		  <tr><td $td1>Title</td>
			  <td $td2><input type='text' name='title' value='$title' size='80'></td></tr>
		  <tr><td $td1>Description</td>
			  <td $td2><textarea name='descr' cols='80' rows='6'>$descr</textarea></td></tr>
		  <tr><td $td1>Photo</td>
			  <td $td2>$photo <input type='file' name='photo'></td></tr>			  
		  <tr><td $td1>Price</td>
			  <td $td2><input type='text' name='price' value='$price'></td></tr>	  
		  <tr><td $td1>Calories</td>
			  <td $td2><input type='text' name='cal' value='$cal'></td></tr>
		  </table>";
			  
// Show Image
	if ($photo != 'None') {
		list($result, $width, $height) = image_resize($photo, $maxw, $maxh); 
		echo "<p style='padding-top:1em; margin:auto; width: 70%; background-color: rgba(255, 255, 255, 0.5); font-weight:bold;'><img src='$photo' width='$width' height='$height'>";
		}
		  
// Action Bar
	echo "<p><table align='center' width='70%' style='background-color: rgba(255, 255, 255, 0.5);'><tr><td>
		  <input type='submit' name='task' value='Add' 	style='background-color:blue;color:white;font-weight:bold;'>
		  <input type='submit' name='task' value='Update' 	style='background-color:lightgreen;font-weight:bold;'>
		  <input type='submit' name='task' value='Remove' 	style='background-color:pink;font-weight:bold;' onclick='return ConfirmDelete();'>		  
		  </td></tr></table></form>
		  <p><a href='dailyspecial.php'><button style='color:white; background-color:green; font-weight:bold;'>Return to Daily Specials</button></a>\n";

// Message
    echo "<p><table align='center' width='70%' style='background-color: rgba(255, 255, 255, 0.5);'><tr>
		  <td $bold>MESSAGE: </td>
		  <td style='color:$msg_color;'>$msg</td>
		  </tr></table>\n"; 
		  
// End of Program
	echo "</body></html>";
	mysqli_close($mysqli);
?>