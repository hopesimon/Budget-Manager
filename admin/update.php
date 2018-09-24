<?php
require_once "../php/db_connect.php";
require_once "../php/savefunctions.php";

session_start();
    if(!isset($_SESSION['login_user'])){
        header('WWW-Authenticate: Basic realm="Restricted Section"');
        header('HTTP/1.0 401 Unauthorized');
        die (header('location: ../'));
    }
    $type = $_SESSION['login_type'];
    if($type == "Budget"){
        header('WWW-Authenticate: Basic realm="Restricted Section"');
        header('HTTP/1.0 401 Unauthorized');
        die (header('location: ../reserve'));
    }

$reviewer = $_SESSION['login_id'];
$comment = sanitizeString($db, $_POST['comments']);
$org_id = $_POST['org_id'];
echo "$reviewer $comment $org_id";
if(isset($_POST['approve'])){
    $update = "UPDATE `requests` SET `comments` = \"" . $comment . "\", `reviewer` = " . $reviewer . ", `appstatus` = \"Approved\" WHERE `id` = " . $org_id;
    $check = $db->query($update);
    if (!$check) die($db->error);
}
elseif(isset($_POST['deny'])){
    $update = "UPDATE `requests` SET `comments` = \"" . $comment . "\", `reviewer` = " . $reviewer . ", `appstatus` = \"Denied\" WHERE `id` = " . $org_id;
    $check = $db->query($update);
    if (!$check) die($db->error);
}
$db->close();
?>