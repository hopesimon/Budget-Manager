<?php
require_once "db_connect.php";
require_once "savefunctions.php";
    
//post org name
$_o_name = sanitizeString($db, $_POST['org_name']);
        
//post tin
$_tin_name = $_POST['nameInputsTIN'];
$_tin_amount = $_POST['amountInputsTIN'];
$_total_tin = 0;

$length = count($_tin_amount);
for($i = 0; $i < $length; $i++){
    $_total_tin = $_total_tin + $_tin_amount[$i];
}
        
//post expenses
$_equip = $_POST['equipment'];
$_imp = $_POST['improvements'];
$_conti = $_POST['contingencies'];
$_other_name = $_POST['nameInputsOTHER'];
$_other_amount = $_POST['amountInputsOTHER'];
$_total_other = 0;

$length = count($_other_amount);
for($i = 0; $i < $length; $i++){
    $_total_other = $_total_other + $_other_amount[$i];
}
        
   
//post tout
$_tout_name = $_POST['nameInputsTOUT'];
$_tout_amount = $_POST['amountInputsTOUT'];
$_total_tout = 0;

$length = count($_tout_amount);
for($i = 0; $i < $length; $i++){
    $_total_tout = $_total_tin + $_tout_amount[$i];
}

//post justifications
$_tin_just = sanitizeString($db, $_POST['tinjust']);
$_equip_just = sanitizeString($db, $_POST['equipjust']);
$_improv_just = sanitizeString($db, $_POST['improvjust']);
$_cont_just = sanitizeString($db, $_POST['contjust']);
$_other_just = sanitizeString($db, $_POST['otherjust']);
$_tout_just = sanitizeString($db, $_POST['toutjust']);
        
$form = saveFormToDB($db, $_o_name, $_total_tin, $_total_other, $_equip, $_imp, $_conti, $_total_tout, $_tin_just, $_tout_just, $_other_just, $_equip_just, $_improv_just, $_cont_just);

$length = count($_tin_name);
for ($i = 0; $i < $length; $i++) {
  saveTransfersInToDB($db, $_o_name, $form, sanitizeString($db, $_tin_name[$i]), $_tin_amount[$i]);
}
        
$length = count($_tout_name);
for ($i = 0; $i < $length; $i++) {
  saveTransfersOutToDB($db, $_o_name, $form, sanitizeString($db, $_tout_name[$i]), $_tout_amount[$i]);
}
        
$length = count($_other_name);
for ($i = 0; $i < $length; $i++) {
  saveExpensesToDB($db, $_o_name, $form, sanitizeString($db, $_other_name[$i]), $_other_amount[$i]);
}

echo "<html><head><script>setTimeout(move, 3000); function move(){location.replace('../index.php');} </script><title>Adding to Database</title></head><body><p>Automatic redirect in 3 seconds. Click <a href='../index.php'>here</a> if you are not automatically redirected.</p></body></html>";
        
$db->close();
?>