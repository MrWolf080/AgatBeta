<?php
	$connect=mysqli_connect('localhost','root','root','salon_beta');
	
	if(!isset($connect))
	{
		die('Error Database connection');
	}
?>