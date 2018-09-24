<?php
    function getInProgress($_db){
        $sql = "SELECT * FROM requests WHERE `appstatus`='In Progress'";
        
        $result = $_db->query($sql);
        
        if (!$result) die($db->error);
    }

    function getApproved($_db){
        $sql = "SELECT * FROM requests WHERE `appstatus`='Approved'";
        
        $result = $_db->query($sql);
        
        if (!$result) die($db->error);
    }

    function getRejected($_db){
        $sql = "SELECT * FROM requests WHERE `appstatus`='Rejected'";
        
        $result = $_db->query($sql);
        
        if (!$result) die($db->error);
    }
?>