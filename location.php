<?php
// dailyspecial.php - Display the Daily Special
// Written by: Luis Fuentes, Dec 2020
 
// Variables
	$pgm		= 'location.php'; 
	$font	    = "\"Brush Script MT\""; 
	$bold		= "style='font-family:$font; color:black; font-weight:bold; font-size:28px;'";	
	$imgdir		= 'images';
	$maxw		= 400;
	$maxh		= 400; 
	$background = "$imgdir/special_background2.jpg";
	$live		= FALSE;
		
// Output 
	echo "<!doctype HTML><html><body align='center' style='background-image: url($background);'>
		  <style>		  
				.map1{
					margin:auto; 
					width: 80%;
				}
				p a, a 
				{
					 text-decoration:none;
				}
		  </style>"; 
	
//	 Title
	echo "<table align='center' width='800'><tr><td align='center'>
		  <p style='font-family:$font; font-size:32px; font-weight:bold;'><a href='dailyspecial.php'>Luigi&#039;s Pasta and Pizza </a> 
		  </tr></table> 
			<table align='center'  width='750' style='background-color: rgba(255, 255, 255, 0.5);font-family:roboto; font-size:24px;'>
				<tr><td width='100'>&nbsp;</td>
				<td align='left' width='300'><br>
					<a href='https://www.google.com/maps/dir//Luigis+Pizza,+39+Montauk+Hwy,+Lindenhurst,+NY+11757/@40.6785646,-73.3652431,17z/data=!4m9!4m8!1m0!1m5!1m1!1s0x89e9d364440c3193:0xf6b73d06dd173e1f!2m2!1d-73.3630544!2d40.6785646!3e0' target='_blank'>39 Montauk Hwy<br>
					Lindenhurst, NY 11757</a><br>		
					<a href='tel:631-991-7900'>(631) 991-7900</a></td>
				<td align='right'><img src='$imgdir/luigis.jpg'></tr>
			</table>
			</td></tr></table>
		  <div>
		  <section class='map1'>
			<p><iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3025.7912322823154!2d-73.36524844944933!3d40.67856864749646!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e9d364440c3193%3A0xf6b73d06dd173e1f!2sLuigi&#39;s%20Pizza!5e0!3m2!1sen!2sus!4v1607484870970!5m2!1sen!2sus' width='750' height='450' frameborder='0' style='border:0;' allowfullscreen='' aria-hidden='false' tabindex='0'></iframe></p>
		  </section>
		  </div>";
//	Back Button

	echo "<table width='500' align='center' style='font-style:italic;'> 
		  <tr><td align='center'><a href='dailyspecial.php'><button style='color:white; background-color:red; font-weight:bold;'>Back to Home</button></a></td></tr>
		  </table></body></html>"; 
?>