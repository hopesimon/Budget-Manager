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
    
    $i = 0;
    while($row = $result->fetch_assoc()) {
        $this_name[$i] = $row["name"];
        $sql = "SELECT * FROM requests WHERE o_name = '$this_name[$i]'";
        $result2 = $db->query($sql);

        if (!$result2) die($db->error);
        while($row2 = $result2->fetch_assoc()) {
            $tin[$i] = $row2["tintotal"];
            $expense[$i] = $row2["expensetotal"];
            $tout[$i] = $row2["touttotal"];
            $net[$i] = $row2["net_inoutflow"];
            $status[$i] = $row2["appstatus"];
            $comments[$i] = $row2["comments"];
        }
        
        $i++;
    }


?>

<!DOCTYPE HTML>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="View the status of your submitted budget applications.">
    <meta name="author" content="Hope Simon">

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
            <a class="navbar-brand" href="reserve">Budget Request Form</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="reserve">Submit form
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="myapps">My apps
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout">Sign out
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">My apps</h1>
                    <div class="row" style="padding:10px;">
                        <div class="col-lg-12">
                            <?php
                                if(isset($status)){
                                    echo "
                                    <table class=\"table table-striped\">
                                        <thead>
                                            <tr>
                                                <td><strong>Name</strong></td>
                                                <td><strong>Transfers In</strong></td>
                                                <td><strong>Transfers Out</strong></td>
                                                <td><strong>Expenses</strong></td>
                                                <td><strong>Net In/Out</strong></td>
                                                <td><strong>App Status</strong></td>
                                                <td><strong>Reviewer Comments</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>";
                                        for($i = 0; $i < count($this_name); $i++){
                                            echo "
                                                <tr>
                                                    <td>$this_name[$i]</td>";
                                            if(isset($tin[$i])){
                                                echo "
                                                    <td>$$tin[$i]</td>
                                                    <td>$$tout[$i]</td>
                                                    <td>$$expense[$i]</td>
                                                    <td>$$net[$i]</td>";
                                            }
                                            else {
                                                echo "
                                                    <td>N/A</td>
                                                    <td>N/A</td>
                                                    <td>N/A</td>
                                                    <td>N/A</td>";
                                            }
                                            if(isset($status[$i])){
                                                echo "
                                                    <td>$status[$i]</td>";
                                            }
                                            else {
                                                echo "<td>No apps</td>";
                                            }
                                            if(isset($comments[$i])){
                                                echo "
                                                    <td>$comments[$i]</td>";
                                            }
                                            else {
                                                echo "<td>No comments</td>";
                                            }
                                            echo "</tr>";
                                        }
                                    echo "</tbody></table>";
                                }
                                else {
                                    echo "<h3> You have no pending apps.</h3>";
                                }
                            ?>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <?php $db->close(); ?>
</body>

</html>
