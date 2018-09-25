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
if(isset($_POST['approve'])){
    $reviewer = $_SESSION['login_id'];
    $comment = sanitizeString($db, $_POST['comments']);
    $org_id = $_POST['org_id'];
    $update = "UPDATE `requests` SET `comments` = \"" . $comment . "\", `reviewer` = " . $reviewer . ", `appstatus` = \"Approved\" WHERE `id` = " . $org_id;
    $check1 = $db->query($update);
    $u_tin = $_POST['this_tin'];
    $u_expense = $_POST['this_expense'];
    $o_name = $_POST['orgs_name'];
    $net = $_POST['this_net'];
    $update2 = "UPDATE `orgcurrent` SET `totalin` = " . $u_tin . ", `totalexpense` = " . $u_expense . ", `totalbudget` = " . $net . " WHERE `name` = \"" . $o_name . "\"";
    $check2 = $db->query($update2);
    if ($check1 && $check2){
        $success = "<div class='row' style='padding:30px;'><div class='alert alert-success' role='alert'>Form updated.</div></div></div>";
    }
    else {
        $success = "<div class='row' style='padding:30px;'><div class='alert alert-danger' role='alert'>Form failed to update.</div></div></div>";
    }
}
elseif(isset($_POST['deny'])){
    $reviewer = $_SESSION['login_id'];
    $comment = sanitizeString($db, $_POST['comments']);
    $org_id = $_POST['org_id'];
    $update = "UPDATE `requests` SET `comments` = \"" . $comment . "\", `reviewer` = " . $reviewer . ", `appstatus` = \"Denied\" WHERE `id` = " . $org_id;
    $check = $db->query($update);
    if ($check){
        $success = "<div class='row' style='padding:30px;'><div class='alert alert-success' role='alert'>Form updated.</div></div></div>";
    }
    else {
        $success = "<div class='row' style='padding:30px;'><div class='alert alert-danger' role='alert'>Form failed to update.</div></div></div>";
    }
}
    // Get id number from URL which is /forms?id=#### or /forms.php?id=####
    $id = $db->real_escape_string($_GET['id']);
    $valid = true;
    if($id == ""){
        $valid = false;
    }
    else {
        // Get row
        $sql = 'SELECT * FROM `requests` WHERE id = ' . $id . '';
        $result = $db->query($sql);

        if (!$result) {$valid = false; die($db->error);}

        while($row = $result->fetch_assoc()){
            $name = $row['o_name'];
            $status = $row['appstatus'];
            $tin = $row['tintotal'];
            $other = $row['other_amount'];
            $equip = $row['equipment_amount'];
            $improv = $row['improvements_amount'];
            $cont = $row['contingencies_amount'];
            $expense = $row['expensetotal'];
            $tout = $row['touttotal'];
            $net = $row['net_inoutflow'];
            $tin_desc = $row['tin_description'];
            $tout_desc = $row['tout_description'];
            $other_desc = $row['other_description'];
            $equip_desc = $row['eq_description'];
            $improv_desc = $row['im_description'];
            $cont_desc = $row['co_description'];
            $date = $row['datesubmitted'];
            $appcomments = $row['comments'];
            $thisreviewer = $row['reviewer'];
        }
        
        if($status != "In Review"){
            $reviewersql = 'SELECT * FROM `users` WHERE id = ' . $thisreviewer . '';
            $reviewresult = $db->query($reviewersql);
            if (!$reviewresult) die($db->error);
            $reviewername = "Unknown";
            while($reviewrow = $reviewresult->fetch_assoc()){
                $reviewername = $reviewrow['name'];
            }
        }

        $sql2 = 'SELECT * FROM `transfersin` WHERE form_id = ' . $id . '';
        $result2 = $db->query($sql2);
        $index_tin = 0;
        while($row2 = $result2->fetch_assoc()){
            $tin_name[$index_tin] = $row2['name'];
            $tin_amount[$index_tin] = $row2['amount'];
            $index_tin = $index_tin + 1;
        }

        $sql3 = 'SELECT * FROM `transfersout` WHERE form_id = ' . $id . '';
        $result3 = $db->query($sql3);
        $index_tout = 0;
        while($row3 = $result3->fetch_assoc()){
            $tout_name[$index_tout] = $row3['name'];
            $tout_amount[$index_tout] = $row3['amount'];
            $index_tout = $index_tout + 1;
        }

        $sql4 = 'SELECT * FROM `otherexpenses` WHERE form_id = ' . $id . '';
        $result4 = $db->query($sql4);
        $index_other = 0;
        while($row4 = $result4->fetch_assoc()){
            $other_name[$index_other] = $row4['name'];
            $other_amount[$index_other] = $row4['amount'];
            $index_other = $index_other + 1;
        }
        
        $real_expense = $expense - $tout;
        $real_expense = round($real_expense, 2, PHP_ROUND_HALF_UP);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Reserve Request - <?php echo"$name" ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Link CSS -->
    <style type="text/css">
        a.tablelink{
            text-decoration: none;
            color: #000;
            display: block;
        }
        a.tablelink:hover{
            text-decoration: none;
            color: #000;
            display: block;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">ASAB Manager</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a href="../logout">
                        <i class="fa fa-sign-out fa-fw"></i>
                    </a>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="admin"><i class="fa fa-dashboard fa-fw"></i> Admin Home Page</a>
                        </li>
                        <li>
                            <a href="../logout"><i class="fa fa-sign-out fa-fw"></i> Log out</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        </div>

        <div id="page-wrapper">
            <div class="row">
                <?php 
                    if(!$valid){
                        if(isset($success)){
                            echo "$success";
                        }
                        else{
                            echo "<div class='row' style='padding:30px;'><div class='alert alert-danger' role='alert'>Invalid form ID</div></div></div>";
                        }
                    }
                    else {
                    if (isset($success)){ echo "$success"; }
                    echo "
                    <div class=\"col-lg-12\">
                    <h1 class=\"page-header\">Form ID: $id</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class=\"row\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        <h2>$name</h2>
                    </div>
                    <!-- /.panel-heading -->
                    <div class=\"panel-body\" contenteditable=\"false\">
                        <h3><span class=\"type\">Reserve</span> Form</h3>
                        <hr>
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3>Transfers In</h3>
                            </div>
                            <!-- /.panel-heading -->
                            <div class=\"panel-body\">
                                <table class=\"table table-striped\" id=\"tin\">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    for($i = 0; $i < count($tin_name); $i++){
                                        echo "<tr><td>$tin_name[$i]</td><td>$$tin_amount[$i]</td></tr>";
                                    }
                                echo "
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td id=\"tintotal\">$$tin</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3>Expenses</h3>
                            </div>
                            <div class=\"panel-body\">
                                <table class=\"table table-striped\" id=\"expenses\" >
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Improvements</td>
                                            <td id=\"improvements\">$$improv</td>
                                        </tr>
                                        <tr>
                                            <td>Contingencies</td>
                                            <td id=\"contingencies\">$$cont</td>
                                        </tr>
                                        <tr>
                                            <td>Equipment</td>
                                            <td id=\"equipment\">$$equip</td>
                                        </tr>";
                                    for($i = 0; $i < count($other_name); $i++){
                                        echo "<tr><td>$other_name[$i]</td><td>$$other_amount[$i]</td></tr>";
                                    }
                          echo         "
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td id=\"expensetotal\">$$real_expense</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3>Transfers Out</h3>
                            </div>
                            <div class=\"panel-body\">
                                <table class=\"table table-striped\" id=\"tout\">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                    for($i = 0; $i < count($tout_name); $i++){
                                        echo "<tr><td>$tout_name[$i]</td><td>$$tout_amount[$i]</td></tr>";
                                    }    
                        echo       "</tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td id=\"touttotal\">$$tout</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3>Net Revenue/(Expense)</h3>
                            </div>
                            <div class=\"panel-body\">
                                <table class=\"table table-striped\" id=\"net\">
                                    <tr>
                                        <td id=\"netamt\">$$net</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class=\"panel panel-default\">
                            <div class=\"panel-heading\">
                                <h3>Justifications</h3>
                            </div>
                            <div class=\"panel-body\">
                                <div class=\"col-lg-4\">
                                    <h4>Transfers In</h4>
                                    <p id=\"tinjust\">$tin_desc</p>
                                </div>
                                <div class=\"col-lg-4\">
                                    <h4>Improvements</h4>
                                    <p id=\"improvjust\">$improv_desc</p>
                                </div>
                                <div class=\"col-lg-4\">
                                    <h4>Contingencies</h4>
                                    <p id=\"contjust\">$cont_desc</p>
                                </div>
                                <div class=\"col-lg-4\">
                                    <h4>Equipment</h4>
                                    <p id=\"equipjust\">$equip_desc</p>
                                </div>
                                <div class=\"col-lg-4\">
                                    <h4>Other</h4>
                                    <p id=\"otherjust\">$other_desc</p>
                                </div>
                                <div class=\"col-lg-4\">
                                    <h4>Transfers Out</h4>
                                    <p id=\"toutjust\">$tout_desc</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.col-lg-12 -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.row -->";
                    if($status == "In Review"){
                        echo "
            <form id = \"respond\" method=\"POST\" action=\"forms.php\" enctype=\"multipart/form-data\">
            <div class=\"row\" id=\"commentsrow\">
                <div class=\"panel panel-default\">
                    <div class=\"panel-heading\">
                        <h3>Your Comments</h3>
                    </div>
                    <div class=\"panel-body\">
                        <textarea name=\"comments\" style=\"width: 80%; height: auto;\"></textarea>
                    </div>
                    <input type = \"number\" style = \"display:none;\" value = \"$id\" name = \"org_id\"></input>
                    <input type = \"number\" style = \"display:none;\" step = \"0.01\" value = \"$tin\" name = \"this_tin\"></input>
                    <input type = \"number\" style = \"display:none;\" step = \"0.01\" value = \"$expense\" name = \"this_expense\"></input>
                    <input type = \"number\" style = \"display:none;\" step = \"0.01\" value = \"$net\" name = \"this_net\"></input>
                    <input type = \"text\" style = \"display:none;\" value = \"$name\" name = \"orgs_name\"></input>
                </div>
            </div>
            <div class=\"row\" style=\"padding-bottom: 20px;\">
                <div class=\"col-lg-6\" align=\"center\">
                    <input type=\"submit\" class=\"btn btn-success btn-lg\" name = \"approve\" value = \"Approve\"></input>
                </div>
                <!-- /.col-lg-6 -->
                <div class=\"col-lg-4\" align=\"center\">
                    <input type=\"submit\" class=\"btn btn-danger btn-lg\" name = \"deny\" value = \"Deny\"></input>
                </div>
            </div>
            </form>
                    ";
                    }
                    elseif($status == "Approved"){
                        echo "
                        <div class=\"row\">
                        <div class = \"panel panel-default\">
                        <div class=\"panel-heading\">
                        <h3>$reviewername's Comments</h3>
                        </div>
                        <div class=\"panel-body\">
                            <p id=\"comments\">$appcomments</p>
                        </div>
                        </div>
                        <div class=\"row\" style=\"padding-bottom: 20px;\">
                        <div class=\"col-lg-12\" align=\"center\">
                            <div style=\"width:100px;height:50px;line-height:58px;border-radius:20px;background-color:#5CB85C; color:#fff;\"><p style=\"display: inline-block;vertical-align: middle;line-height:normal;\">Approved</p></div>
                        </div>
                        </div>
                        ";
                    }
                    elseif($status == "Denied"){
                        echo "
                        <div class=\"row\">
                        <div class = \"panel panel-default\">
                        <div class=\"panel-heading\">
                        <h3>$reviewername's Comments</h3>
                        </div>
                        <div class=\"panel-body\">
                            <p id=\"comments\">$appcomments</p>
                        </div>
                        </div>
                        <div class=\"row\" style=\"padding-bottom: 20px;\">
                        <div class=\"col-lg-12\" align=\"center\">
                            <div style=\"width:100px;height:50px;line-height:58px;border-radius:20px;background-color:#D9534F; color:#fff;\"><p style=\"display: inline-block;vertical-align: middle;line-height:normal;\">Denied</p></div>
                        </div>
                        </div>
                        ";
                    }
                }
                ?>
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
<?php
    $db->close();
?>