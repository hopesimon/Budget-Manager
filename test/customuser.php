<?php

require_once "../php/db_connect.php";

session_start();
    if(isset($_SESSION['login_user'])){
        $type = $_SESSION['login_type'];
        if($type == "Budget"){
            header('WWW-Authenticate: Basic realm="Restricted Section"');
            header('HTTP/1.0 401 Unauthorized');
            die (header('location: ../reserve'));
        }
        if($type == "ASAB"){
            header('WWW-Authenticate: Basic realm="Restricted Section"');
            header('HTTP/1.0 401 Unauthorized');
            die (header('location: ../admin/admin'));
        }
    }

$type = "Budget";
$index = 0;

$sql = "SELECT * FROM users WHERE type = '$type'";
$result = $db->query($sql);

if (!$result) die($db->error);

echo "<!DOCTYPE HTML>
        <html>
            <head>
            </head>
            <body>
                <p align='center'>Apologies for lack of CSS, but this is just a test function!</p>
                <div align='center'>
                    <form action='customlogincode.php' method='post'>
                    <select name = 'my_name' style='width: 30%; height: 20px; font-size: 12pt;'>";
    while($row = $result->fetch_assoc()){
        $name[$index] = $row["name"];
        $id[$index] = $row["id"];
        echo "<option value = \"" . $id[$index] . "\">" . $name[$index] . "</>";
        $index = $index + 1;
    }
    echo "          </select>
                    <br />
                    <br />
                    <input type='submit' style='width:10%; height:5%; font-size:12pt; background-color:red; color:white; border-radius:5px;'></input>
                    </form>
                </div>
            </body>
        </html>";

$db->close();

?>