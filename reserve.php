<?php

    require_once "php/db_connect.php";
    require_once "php/savefunctions.php";

    session_start();
        if(!isset($_SESSION['login_user'])){
            header('WWW-Authenticate: Basic realm="Restricted Section"');
            header('HTTP/1.0 401 Unauthorized');
            die (header('location: /'));
        }

    $name = $_SESSION['login_name'];
    $email = $_SESSION['login_user'];
    $id = $_SESSION['login_id'];

    $sql = "SELECT `name` FROM orgcurrent WHERE manager_id = $id";
    $result = $db->query($sql);

    if (!$result) die($db->error);
    
    if(isset($_POST['submit'])){
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

        $check1 = true;
        $check2 = true;
        $check3 = true;
        
        $length = count($_tin_name);
        for ($i = 0; $i < $length; $i++) {
          $check1 = saveTransfersInToDB($db, $_o_name, $form, sanitizeString($db, $_tin_name[$i]), $_tin_amount[$i]);
        }

        $length = count($_tout_name);
        for ($i = 0; $i < $length; $i++) {
          $check2 = saveTransfersOutToDB($db, $_o_name, $form, sanitizeString($db, $_tout_name[$i]), $_tout_amount[$i]);
        }

        $length = count($_other_name);
        for ($i = 0; $i < $length; $i++) {
          $check3 = saveExpensesToDB($db, $_o_name, $form, sanitizeString($db, $_other_name[$i]), $_other_amount[$i]);
        }
        
        if($check1 && $check2 && $check3){
            $success = "<div class=\"alert alert-success\" role=\"alert\">
                            Form successfully submitted.
                       </div>";
        }
        else {
            $success = "<div class=\"alert alert-danger\" role=\"alert\">
                            Form failed to submit.
                       </div>";;
        }
    }


?>

<!DOCTYPE HTML>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ASAB Office</title>
    <!-- Script -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="js/addAnother.js"></script>
    <script src="js/textcount.js"></script>
    <script src="js/totals.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fau.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <style>
        .extrapadding{
            padding-right: 25%;
        }
        
        .logout{
            color: #fff;
            text-decoration: none;
        }
        
        .logout:hover{
            color: #fff;
            text-decoration: none;
        }
        
      body {
        padding-top: 54px;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }
        

    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-fau fixed-top">
        <div class="container">
            <a class="navbar-brand" href="reserve.php">Budget Request Form</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="reserve">Submit form
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="myapps">My apps
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout">Sign out
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Reserve Request Form</h1>
                <form id="request" method="POST" action="reserve.php" enctype="multipart/form-data">
                    <?php
                        if (isset($success)){ echo "$success"; }
                    ?>
                    <div class="row" style="padding:10px;">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <h2>Select Organization</h2>
                                <select class="form-control" id="org_name" name="org_name"><option>Select One</option>
                                    <?php
                                        while($row = $result->fetch_assoc()) {
                                            $this_name = $row["name"];
                                            echo "<option name='" . $this_name . "' id='" . $this_name . "'>" . $this_name . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br />
                    <hr>
                    <div class="row" style="padding-top:10px;">
                        <h2>Transfers In:</h2>
                    </div>
                    <div class="row" id="TINRes">
                        <div class="col-lg-6">
                            <h5>Name: &nbsp;&nbsp;<input type="text" id="TIN name 1" name="nameInputsTIN[]" maxlength="30" placeholder="Enter Name"></h5>
                        </div>
                        <div class="col-lg-6">
                            <h5>Amount: &nbsp;&nbsp;<input type="number" id="TIN amount 1" name="amountInputsTIN[]" placeholder="0.00" min="0" step="0.01" onchange="updateTinTotal();"></h5>
                        </div>
                    </div>
                    <h3 id="totalTIN">Total: $0</h3>
                    <button class="btn btn-blue btn-block" type="button" onclick="addAnotherTIN();">Add Another</button>
                    <br />
                    <hr>
                    <div class="row" style="padding:10px;">
                        <h2>Expenses:</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <h4>Equipment Amount: </h4>
                            <input type="number" name="equipment" id="equipment" placeholder="0.00" min="0" step="0.01" onchange="updateExpenseTotal();" />
                        </div>
                        <div class="col-lg-4">
                            <h4>Improvements Amount: </h4>
                            <input type="number" name="improvements" id="improvements" placeholder="0.00" min="0" step="0.01" onchange="updateExpenseTotal();" />
                        </div>
                        <div class="col-lg-4">
                            <h4>Contingencies Amount: </h4>
                            <input type="number" name="contingencies" id="contingencies" placeholder="0.00" min="0" step="0.01" onchange="updateExpenseTotal();" />
                        </div>
                    </div>
                    <div class="row" style="padding:10px;">
                        <h3>Other Expenses:</h3>
                    </div>
                    <div class="row" id="otherRes">
                        <div class="col-lg-6">
                            <h5>Name: &nbsp;&nbsp;<input type="text" id="OTHER name 1" name="nameInputsOTHER[]" maxlength="30" placeholder="Enter Name"></h5>
                        </div>
                        <div class="col-lg-6">
                            <h5>Amount: &nbsp;&nbsp;<input type="number" id="OTHER amount 1" name="amountInputsOTHER[]" placeholder="0.00" step="0.01" min="0" onchange="updateExpenseTotal();"></h5>
                        </div>
                    </div>
                    <br />
                    <h3 id="expenseTotal">Total: $0</h3>
                    <button class="btn btn-blue btn-block" type="button" onclick="addAnotherOTHER();">Add Another</button>
                    <br />
                    <hr>
                    <div class="row" style="padding-top:10px;">
                        <h2>Transfers Out:</h2>
                    </div>
                    <div class="row" id="TOUTRes">
                        <div class="col-lg-6">
                            <h5>Name: &nbsp;&nbsp;<input type="text" id="TOUT name 1" name="nameInputsTOUT[]" maxlength="30" placeholder="Enter Name"></h5>
                        </div>
                        <div class="col-lg-6">
                            <h5>Amount: &nbsp;&nbsp;<input type="number" id="TOUT amount 1" name="amountInputsTOUT[]" placeholder="0.00" min="0" step="0.01" onchange="updateToutTotal();"></h5>
                        </div>
                    </div>
                    <br />
                    <h3 id="totalTOUT">Total: $0</h3>
                    <button class="btn btn-blue btn-block" type="button" onclick="addAnotherTOUT();">Add Another</button>
                    <br />
                    <hr>
                    <div class="row" style="padding-top:10px;">
                        <h2>Net Revenue/(Expense): $<span id="netres">0</span></h2>
                    </div>
                    <br />
                    <hr>
                    <div align="center" class="row" style="padding-top:10px;">
                        <table id="Budget Summary Res" align="center">
                            <tr>
                                <th>Requested Budget</th>
                            </tr>
                            <tr>
                                <td>Transfers In</td>
                                <td id="TINResAmt" style="padding-left:40px;"></td>
                            </tr>
                            <tr>
                                <td>Expenses</td>
                                <td id="ExpensesResAmt" style="padding-left:40px;"></td>
                            </tr>
                            <tr>
                                <td>Transfers Out</td>
                                <td id="TOUTResAmt" style="padding-left:40px;"></td>
                            </tr>
                            <tr>
                                <td>2.8% Overhead</td>
                                <td id="OverheadResAmt" style="padding-left:40px;"></td>
                            </tr>
                            <tr>
                                <td>Total Expense</td>
                                <td id="totalExpenseResAmt" style="padding-left:40px;"></td>
                            </tr>
                        </table>
                    </div>
                    <br />
                    <hr>
                    <div class="row" style="padding: 10px;">
                        <h2>Justifications</h2>
                    </div>
                    <div class="row">
                        <h4>Transfers In</h4>
                    </div>
                    <div class="row extrapadding">
                        <textarea type="text" style="width: 100%; height:auto;" placeholder="Enter your justification here. Max 140 characters." maxlength="140" name="tinjust"></textarea><span class="after"><span class="charcount">140</span> characters remaining.</span>
                    </div>
                    <div class="row" style="padding-top:10px;">
                        <h4>Equipment</h4>
                    </div>
                    <div class="row extrapadding">
                        <textarea type="text" style="width: 100%; height:auto;" placeholder="Enter your justification here. Max 140 characters." maxlength="140" name="equipjust"></textarea><span class="after"><span class="charcount">140</span> characters remaining.</span>
                    </div>
                    <div class="row" style="padding-top:10px;">
                        <h4>Improvements</h4>
                    </div>
                    <div class="row extrapadding">
                        <textarea type="text" style="width: 100%; height:auto;" placeholder="Enter your justification here. Max 140 characters." maxlength="140" name="improvjust"></textarea><span class="after"><span class="charcount">140</span> characters remaining.</span>
                    </div>
                    <div class="row" style="padding-top:10px;">
                        <h4>Contingencies</h4>
                    </div>
                    <div class="row extrapadding">
                        <textarea type="text" style="width: 100%; height:auto;" placeholder="Enter your justification here. Max 140 characters." maxlength="140" name="contjust"></textarea><span class="after"><span class="charcount">140</span> characters remaining.</span>
                    </div>
                    <div class="row" style="padding-top:10px;">
                        <h4>Other (if applicable)</h4>
                    </div>
                    <div class="row extrapadding">
                        <textarea type="text" style="width: 100%; height:auto;" placeholder="Enter your justification here. Max 140 characters." maxlength="140" name="otherjust"></textarea><span class="after"><span class="charcount">140</span> characters remaining.</span>
                    </div>
                    <div class="row" style="padding-top:10px;">
                        <h4>Transfers Out</h4>
                    </div>
                    <div class="row extrapadding">
                        <textarea type="text" style="width: 100%; height:auto;" placeholder="Enter your justification here. Max 140 characters." maxlength="140" name="toutjust"></textarea><span class="after"><span class="charcount">140</span> characters remaining.</span>
                    </div>
                    <div class="row" style="padding:20px;">
                        <button class="btn btn-red btn-block" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php $db->close(); ?>
</body>

</html>
