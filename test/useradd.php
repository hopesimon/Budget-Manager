<?php
require_once "../php/db_connect.php";

function sanitizeString($_db, $str)
{
    $str = strip_tags($str);
    $str = htmlentities($str);
    $str = stripslashes($str);
    return mysqli_real_escape_string($_db, $str);
}

function addUserToDB($_db, $_name, $_email)
{
    $_type = "Budget";
    /* Prepared statement, stage 1: prepare query */
    if (!($stmt = $_db->prepare("INSERT INTO users(name, fauemail, type) VALUES (?, ?, ?)")))
    {
        echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
    }
    /* Prepared statement, stage 2: bind parameters*/
    if (!$stmt->bind_param('sss', $_name, $_email, $_type))
    {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }

    /* Prepared statement, stage 3: execute*/
    if (!$stmt->execute())
    {
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
    }

}

if(isset($_POST['my_name']))
    {
        $myname = sanitizeString($db, $_POST['my_name']);
        $myemail = sanitizeString($db, $_POST['my_email']);

        addUserToDB($db, $myname, $myemail);

        echo "<html><head><script>setTimeout(move, 3000); function move(){location.replace('../');} </script><title>Adding to Database</title></head><body><p>Finished script. Automatic redirect in 3 seconds. Click <a href='../'>here</a> if you are not automatically redirected.</p></body></html>";
    }
$db->close();
?>