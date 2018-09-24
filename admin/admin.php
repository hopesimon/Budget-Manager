<?php
    require_once "../php/db_connect.php";
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

    $name = $_SESSION['login_name'];
    $email = $_SESSION['login_user'];
    $id = $_SESSION['login_id'];

    $sql = 'SELECT * FROM `requests` WHERE appstatus = \'In Review\'';
    $result = $db->query($sql);

    if (!$result) die($db->error);
    $indexip = 0;
    while($row = $result->fetch_assoc()){
        $o_nameip[$indexip] = $row['o_name'];
        $dateip[$indexip] = $row['datesubmitted'];
        $idip[$indexip] = $row['id'];
        $indexip = $indexip + 1;
    }

    $sql2 = 'SELECT * FROM `requests` WHERE appstatus = \'Approved\'';
    $result2 = $db->query($sql2);

    if (!$result2) die($db->error);
    $indexacc = 0;
    while($row = $result2->fetch_assoc()){
        $o_nameacc[$indexacc] = $row['o_name'];
        $dateacc[$indexacc] = $row['datesubmitted'];
        $idacc[$indexacc] = $row['id'];
        $indexacc = $indexacc + 1;
    }

    $sql3 = 'SELECT * FROM `requests` WHERE appstatus = \'Denied\'';
    $result3 = $db->query($sql3);

    if (!$result3) die($db->error);
    $indexden = 0;
    while($row = $result3->fetch_assoc()){
        $o_nameden[$indexden] = $row['o_name'];
        $dateden[$indexden] = $row['datesubmitted'];
        $idden[$indexden] = $row['id'];
        $indexden = $indexden + 1;
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

    <title>ASAB Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

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
        
        a.no-dec{
            text-decoration: none;
            color: #000;
            display: block;
        }
        a.no-dec:hover{
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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">ASAB Admin</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <a href="../logout"><i class="fa fa-sign-out fa-fw"></i></a>
                </li>
            </ul>
            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="/"><i class="fa fa-dashboard fa-fw"></i> Admin Home</a>
                        </li>
                        <li>
                            <a href="../logout"><i class="fa fa-sign-out fa-fw"></i> Sign out</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            In Review
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-inprogress">
                                <thead>
                                    <tr>
                                    <th>Organization</th>
                                    <th>Date Submitted</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for($i = 0; $i < count($o_nameip); $i++){
                                            echo "<tr><td><a class = 'no-dec' href='forms?id=$idip[$i]'>$o_nameip[$i]</a></td><td><a class = 'no-dec' href='forms?id=$idip[$i]'>$dateip[$i]</a></td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            Approved
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-approved">
                                <thead>
                                    <tr>
                                        <th>Organization</th>
                                        <th>Date Submitted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for($i = 0; $i < count($o_nameacc); $i++){
                                            echo "<tr><td><a class = 'no-dec' href='forms?id=$idacc[$i]'>$o_nameacc[$i]</a></td><td><a class = 'no-dec' href='forms?id=$idacc[$i]'>$dateacc[$i]</a></td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <div class="col-lg-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            Denied
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-denied">
                                <thead>
                                    <tr>
                                        <th>Organization</th>
                                        <th>Date Submitted</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for($i = 0; $i < count($o_nameden); $i++){
                                            echo "<tr><td><a class = 'no-dec' href='forms?id=$idden[$i]'>$o_nameden[$i]</a></td><td><a class = 'no-dec' href='forms?id=$idip[$i]'>$dateden[$i]</a></td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-inprogress').DataTable({
            responsive: true
        });
    });
    $(document).ready(function() {
        $('#dataTables-approved').DataTable({
            responsive: true
        });
    });
    $(document).ready(function() {
        $('#dataTables-denied').DataTable({
            responsive: true
        });
    });
    </script>
            <!-- /.page-wrapper -->
    <?php $db->close(); ?>
</body>

</html>
