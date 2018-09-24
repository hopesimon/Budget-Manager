<?php

    require_once "../php/db_connect.php";
    
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
                <h1>We only require 2 inputs to create a new organization:<br /><ol><li>Name<ul><li>Just the name of the organization</li><li>Max. 30 characters</li></ul></li><li>Manager ID<ul><li>ID of budget manager</li><li>The ID is auto-filled based on which name you select.</li></ul></li></ol></h1>
                <div align='center'>
                    <form action='orgadd.php' method='post'>
                    <input align='center' style='width: 30%; height:20px; font-size:12pt; text-align:center;' type='text' name='org_name' placeholder='Organization Name' maxlength='30'></input>
                    <br />
                    <br />
                    <select name = 'man_id' style='width: 30%; height: 20px; font-size: 12pt;'>";
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