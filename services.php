<?php
	session_start();
	require_once 'lk\vendor\db_connection.php';
	
	$count_empl=mysqli_query($connect, "SELECT COUNT(*) FROM `service`");
	if(mysqli_fetch_array($count_empl)[0]==0)
		echo "Услуг пока нет.<br>";
	
	if($_SESSION['message'])
	{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
	
	$query=mysqli_query($connect, "SELECT * FROM `service`");
	while( $arr = mysqli_fetch_assoc( $query ) )
	{
		echo $arr['name'].'<br>';
		echo $arr['descr'].'<br>';
		echo $arr['price'].'<br>';
		if($_SESSION['user'])
			if($_SESSION['user']['role']>1)
				echo $arr['cont'].'<br>';
		$id_serve=$arr['id'];
		$query2=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_serv`='$id_serve'");
		if(mysqli_num_rows($query2)>0)
		{
			echo 'Сотрудники, выполняющие услугу: <br>';
			while($ids=mysqli_fetch_assoc($query2))
			{
				$id_empl=$ids['id_empl'];
				$fio=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `fio` FROM `empl` WHERE `id`='$id_empl'"))['fio'];
				echo $fio.'<br>';
			}
			echo '<br><br>';
		}
	}
	
	if($_SESSION['user'])
			if($_SESSION['user']['role']==3)
			{
				echo '<a href="admin/addservice.php">Добавить услугу</a>';
				echo '<a href="admin/editservice.php">Редактировать услугу</a><br>';
			}
	mysqli_close($connect);
?>