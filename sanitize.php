<?php
// sanitize.php - Sanitize Input
// Written by: Luis Fuentes, Dec 2020

	function sanitize($mysqli, $var) {
		$var = trim($var);
		$var = mysqli_real_escape_string($mysqli, $var);
		if (get_magic_quotes_gpc()) $var = stripslashes($var);
		$var = strip_tags($var);
		$var = htmlentities($var);
		return($var);
		}
?>