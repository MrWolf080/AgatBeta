<?php
	$connect=mysqli_connect('localhost','root','root','salon_beta');
	
	if(!isset($connect))
	{
		die('Error Database connection');
	}
	
	function antisql($connect, $var)
	{
		$var  =  htmlspecialchars(stripslashes(trim($var)));
		$var  =  mysqli_real_escape_string($connect,$var);
		return  $var;
	}
?>