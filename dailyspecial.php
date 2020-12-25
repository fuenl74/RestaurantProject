<?php
// dailyspecial.php - Display the Daily Special
// Written by: Luis Fuentes, Dec 2020

// Includes
	require('xx_mysqli_connect.php');
	require('image_resize.php');

// Variables
	$pgm		= 'dailyspecial.php';
	$edit		= 'special_update.php';
	$location	= 'location.php'; 
	$table		= 'specials'; 
	$font	    = "\"Brush Script MT\""; 
	$bold		= "style='font-family:$font; color:black; font-weight:bold; font-size:28px;'";	
	$imgdir		= 'images';
	$maxw		= 400;
	$maxh		= 400; 
	$background = "$imgdir/special_background2.jpg";
	$live		= FALSE;
	
// Get Input
	if (isset($_POST['day']))		$day 	= $_POST['day'];	else $day		= NULL;
	
// Query table for Daily Special Details
	if ($day != NULL) {	
		$query = "SELECT title, descr, photo, price, calories FROM $table WHERE day = '$day'";
		$result = mysqli_query($mysqli, $query);
		if (!$result) echo "Query failed [$query] – " . mysqli_error($mysqli); 
		else list($title, $descr, $photo, $price, $cal) = mysqli_fetch_row($result);
		}
		
// Output 
	echo "<!doctype HTML><html><body align='center' style='background-image: url($background);'>
		  <style>
			  .dropdown-contentt { 
				  color: black;
				  font-weight: bold;
				  font-family: roboto;
				  font-size: 70%;
				  background-color: white;
				  min-width: 165px;
				  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
				  padding: 5px 14px;
				  z-index: 1;				
				} 
		  </style>"; 
	
// Select a Day Dropdown
	echo "<table align='center' width='800'><tr><td align='center'>
		  <p style='font-family:$font; font-size:32px; font-weight:bold;'>Luigi&#039;s Pasta and Pizza
		  <br>~~ Specials ~~
		  <p>&nbsp;
		  <form action='$pgm' method='post'> 
		  <p $bold>Select ~  <select name='day' class='dropdown-contentt' onchange='this.form.submit()'>
		  <option value='' >Select</option>\n";
	$query = "SELECT day FROM $table";
	$result = mysqli_query($mysqli, $query);
	if (!$result) echo "Query failed [$query] – " . mysqli_error($mysqli); 		  
	while(list($dayx) = mysqli_fetch_row($result)) {
		if ($dayx == $day)	$se = 'selected';	else $se = NULL;
		echo "<option $se>$dayx</option>\n";
		}
	echo "</select></form>\n";

// Details
	if ($day != NULL) {
		list($result, $width, $height) = image_resize($photo, $maxw, $maxh); 
		echo "<p style='font-family:$font; font-size:24px; text-decoration:underline; font-weight:bold;'>$title
			  <table width='500' align='center' style='font-style:italic;'>
			  <tr><td align='center'><b>$descr</b></td></tr>
			  <tr><td align='center' style='font-family:$font; font-size:20px; font-weight:bold;'>~~~ $price ~~~</td></tr>
			  <tr><td align='center' style='font-family:$font; font-size:20px; font-weight:bold;'>~~~ $cal Calories~~~</td></tr>
			  <tr><td align='center'><p><img src='$photo' width='$width' height='$height'></td></tr>
			  </table>";
		}
	
// End of Program
	if ($live){
		$edit_button = NULL;
		$location_button = "<table width='500' align='center' style='font-style:italic;'> 
							<tr><td align='center'><a href='$location'><button style='color:white; background-color:red; font-weight:bold;'>Location</button></a></td></tr>
							</table>";
	}
	else {
		if ($day != NULL) $edit .= "?d=$day";
		$edit_button = "<table width='500' align='center' style='font-style:italic;'>
						<tr><td align='center'><a href='$edit'><button style='color:white; background-color:red; font-weight:bold;'>Edit</button></a></td>
						<td align='center'><a href='$location'><button style='color:white; background-color:red; font-weight:bold;'>Location</button></a></td></tr>
						</table>";
		$location_button = NULL;
		}
	echo "$edit_button $location_button
		  </td><td width='70'></td>
		  </tr></table></body></html>";
	mysqli_close($mysqli);	
?>