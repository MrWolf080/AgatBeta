<?php
	require_once 'db_connection.php';
	
	function add_minutes_date($date, $minutes)
	{
		$orderDateTimestamp = strtotime($date);
		$endDateTimeStamp = strtotime('+'.$minutes.' minutes', $orderDateTimestamp);
		$orderDate = date('d/m/Y H:i:s', $orderDateTimestamp);
		$endDate = date('d/m/Y H:i:s', $endDateTimeStamp);
		return $endDate;
	}
	
	function add_minutes_time($time, $minutes)
	{
		$orderDateTimestamp = strtotime($time);
		$endDateTimeStamp = strtotime('+'.$minutes.' minutes', $orderDateTimestamp);
		$orderDate = date('H:i', $orderDateTimestamp);
		$endDate = date('H:i', $endDateTimeStamp);
		return $endDate;
	}
	
	function create_time_arr($begin, $end, $range)
	{
		$arr=array();
		$start=strtotime($begin);
		$end=strtotime($end);
		while($start<$end)
		{
			array_push($arr, date('H:i',$start));
			$start=strtotime('+'.$range.' minutes', $start);
		}
		return $arr;
	}
	
	function time_arr($connect)
	{
		$query=mysqli_query($connect, "SELECT * FROM `settings`");
		$timeset=mysqli_fetch_assoc($query);
		$time_arr=create_time_arr($timeset['begin'],$timeset['end'],$timeset['space']);
		return $time_arr;
	}
	
	function is_interval1_inside_interval2($begin1, $end1, $begin2, $end2)
	{
		$begin1=strtotime($begin1);
		$end1=strtotime($end1);
		$begin2=strtotime($begin2);
		$end2=strtotime($end2);
		return $begin1>=$begin2&&$end1<=$end2;
	}
	
	function is_in_interval($begin, $end, $time)
	{
		$begin=strtotime($begin);
		$end=strtotime($end);
		$time=strtotime($time);
		return !(($time<=$begin&&$time<=$end)||($time>=$begin&&$time>=$end));
	}
	
	function time_arr_master_not_empty($connect, $id_empl, $date)
	{
		$arr=array();
		$date=$date.'%';
		$query=mysqli_query($connect, "SELECT `id_serv`, `date` FROM `record` WHERE `date` LIKE '$date' AND `id_empl` = '$id_empl'");
		while($serv=mysqli_fetch_assoc($query))
		{
			$id_serv=$serv['id_serv'];
			$date_serv=$serv['date'];
			$time_serv=substr($date_serv,11,5);
			$cont=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `cont` FROM `service` WHERE `id` = '$id_serv'"))['cont'];
			$arr[$time_serv]=substr(add_minutes_time($time_serv,$cont),0,5);
		}
		return $arr;
	}
?>