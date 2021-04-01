<?php
	session_start();
	require_once 'lk\vendor\db_connection.php';
	
	$count_empl=mysqli_query($connect, "SELECT COUNT(*) FROM `empl`");
	if(mysqli_fetch_array($count_empl)[0]==0)
		echo "Сотрудников пока нет.<br>";

	if($_SESSION['message'])
	{
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}
	
	$query=mysqli_query($connect, "SELECT * FROM `empl`");
	while( $arr = mysqli_fetch_assoc( $query ) )
	{
        echo '<img src="data:image/*;base64,'.base64_encode($arr['photo']).'" /><br>';
		echo $arr['fio'].'<br>';
		echo $arr['email'].'<br>';
		echo $arr['descr'].'<br>';
		$id_empl=$arr['id'];
		$query2=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_empl`='$id_empl'");
		if(mysqli_num_rows($query2)>0)
		{
			echo 'Услуги, выполняемые сотрудником: <br>';
			while($ids=mysqli_fetch_assoc($query2))
			{
				$id_serv=$ids['id_serv'];
				$name=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name` FROM `service` WHERE `id`='$id_serv'"))['name'];
				echo $name.'<br>';
			}
			echo '<br><br>';
		}
	}
	
	if($_SESSION['user'])
			if($_SESSION['user']['role']==3)
			{
				echo '<a href="admin/addempl.php">Добавить сотрудника</a><br>';
				echo '<a href="admin/editempl.php">Редактировать сотрудника</a><br>';
			}
	mysqli_close($connect);
?>