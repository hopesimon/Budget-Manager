<?php
    function sanitizeString($_db, $str)
    {
        $str = strip_tags($str);
        $str = htmlentities($str);
        $str = stripslashes($str);
        return mysqli_real_escape_string($_db, $str);
    }

    function saveFormToDB($_db, $_o_name, $_tin, $_other, $_equip, $_improv, $_con, $_tout, $_tin_d, $_tout_d, $_other_d, $_eq_d, $_im_d, $_co_d){

        /* Prepared statement, stage 1: prepare query */
        if (!($stmt = $_db->prepare("INSERT INTO requests(o_name, tintotal, other_amount, equipment_amount, improvements_amount, contingencies_amount, expensetotal, touttotal, net_inoutflow, tin_description, tout_description, other_description, eq_description, im_description, co_description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")))
        {
            echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
        }

        $_expense = $_tout + $_other + $_equip + $_improv + $_con;
        // $_expense = $_expense * 0.028;

        $_net = $_tin - $_expense;

        /* Prepared statement, stage 2: bind parameters*/
        if (!$stmt->bind_param('sddddddddssssss', $_o_name, $_tin, $_other, $_equip, $_improv, $_con, $_expense, $_tout, $_net, $_tin_d, $_tout_d, $_other_d, $_eq_d, $_im_d, $_co_d))
        {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        /* Prepared statement, stage 3: execute*/
        if (!$stmt->execute())
        {
            echo "Failed to save form: (" . $stmt->errno . ") " . $stmt->error;
        }

        sleep(3);

        $theresult = $_db->query("SELECT MAX(id) FROM requests LIMIT 1");
        if($theresult->num_rows){
            $row=$theresult->fetch_array(MYSQLI_NUM);
            $theresult->close();

            $form_id = $row[0];
        }
        return $form_id;
    }

    function saveTransfersInToDB($_db, $_o_name, $_form_id, $_name, $_amount){
        /* Prepared statement, stage 1: prepare query */
        if (!($stmt = $_db->prepare("INSERT INTO transfersin(o_name, form_id, name, amount) VALUES (?, ?, ?, ?)")))
        {
            echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
            return false;
        }

        /* Prepared statement, stage 2: bind parameters*/
        if (!$stmt->bind_param('sisd', $_o_name, $_form_id, $_name, $_amount))
        {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }

        /* Prepared statement, stage 3: execute*/
        if (!$stmt->execute())
        {
            echo "Failed to save TIN: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        
        return true;
    }

    function saveTransfersOutToDB($_db, $_o_name, $_form_id, $_name, $_amount){
        /* Prepared statement, stage 1: prepare query */
        if (!($stmt = $_db->prepare("INSERT INTO transfersout(o_name, form_id, name, amount) VALUES (?, ?, ?, ?)")))
        {
            echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
            return false;
        }

        /* Prepared statement, stage 2: bind parameters*/
        if (!$stmt->bind_param('sisd', $_o_name, $_form_id, $_name, $_amount))
        {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }

        /* Prepared statement, stage 3: execute*/
        if (!$stmt->execute())
        {
            echo "Failed to save TOUT: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        return true;
    }

    function saveExpensesToDB($_db, $_o_name, $_form_id, $_name, $_amount){
        /* Prepared statement, stage 1: prepare query */
        if (!($stmt = $_db->prepare("INSERT INTO otherexpenses(o_name, form_id, name, amount) VALUES (?, ?, ?, ?)")))
        {
            echo "Prepare failed: (" . $_db->errno . ") " . $_db->error;
            return false;
        }

        /* Prepared statement, stage 2: bind parameters*/
        if (!$stmt->bind_param('sisd', $_o_name, $_form_id, $_name, $_amount))
        {
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }

        /* Prepared statement, stage 3: execute*/
        if (!$stmt->execute())
        {
            echo "Failed to save expenses: (" . $stmt->errno . ") " . $stmt->error;
            return false;
        }
        return true;
    }
?>