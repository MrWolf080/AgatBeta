<?php
	$connect=mysqli_connect('localhost','a0530309_agat','root','a0530309_agat');
	
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