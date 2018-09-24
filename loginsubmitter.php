<?php
require_once "php/db_connect.php";

    $email = "manager";

    $sql = "SELECT * FROM users WHERE fauemail = '$email'";
    $result = $db->query($sql);

    if (!$result) die($db->error);
	elseif ($result->num_rows)
	{
		$row = $result->fetch_array(MYSQLI_NUM);

		$result->close();
        
        session_start();
        $_SESSION['login_user'] = $row[2];
        $_SESSION['login_name'] = $row[1];
        $_SESSION['login_type'] = $row[3];
        $_SESSION['login_id'] = $row[0];
        header('location: reserve');
	}

    $db->close();
?>