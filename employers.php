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
        ?>
        <div class="all"><ul>
        <div class="1"><img src="data:image/*;base64,<? echo base64_encode($arr['photo']); ?>" /><br></div>

        <div class="2"><? echo $arr['fio']; ?></div>
        <div class="3"><? echo $arr['email']; ?></div>
        <div class="4"><? echo $arr['descr']; ?></div>
        <?
        $id_empl=$arr['id'];
        $query2=mysqli_query($connect, "SELECT * FROM `emplserv` WHERE `id_empl`='$id_empl'");
        if(mysqli_num_rows($query2)>0)
        {
        ?>

        <div class="5">Услуги, выполняемые сотрудником:</div>
            <?
            while($ids=mysqli_fetch_assoc($query2))
            {
                $id_serv=$ids['id_serv'];
                $name=mysqli_fetch_assoc(mysqli_query($connect, "SELECT `name` FROM `service` WHERE `id`='$id_serv'"))['name'];
                ?>
            <div class="6"><? echo $name; ?></div></ul>
                <?
            }

        }
        ?>
        </div>
        <?

    }

    if($_SESSION['user'])
            if($_SESSION['user']['role']==3)
            {
                echo '<a href="admin/addempl.php">Добавить сотрудника</a><br>';
                echo '<a href="admin/editempl.php">Редактировать сотрудника</a><br>';
            }
    mysqli_close($connect);
?>
