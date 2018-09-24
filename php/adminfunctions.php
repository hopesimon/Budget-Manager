<?php
    function alterCurrentOrgDB($_db, $_o_name, $_tin, $_expense){
        $overhead = $_expense * 0.028;
        $newexpense = $_expense + $overhead;
        $budget = -1 * ($newexpense + $_tin);
        
        $sql = "UPDATE `orgcurrent` SET `totalin`=$_tin, `totalexpense`=$_expense, `overhead`=$overhead, `totalbudget`=$budget WHERE `name`='$_o_name'";
            
        $result = $_db->query($sql);
        if (!$result) die($db->error);
    }

    function updateAppStatus($_db, $_form_id, $_status, $_reviewer, $_comments){
        $sql = "UPDATE `requests` SET `appstatus`='$_status', `reviewer`=$_reviewer, `comments`='$_comments' WHERE `id`=$_form_id";
        
        $result = $_db->query($sql);
        
        if (!$result) die($db->error);
        
        if($_status == "Approved") return true;
        else return false;
    }
?>