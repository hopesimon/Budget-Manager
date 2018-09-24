<?php
require_once "php/db_connect.php";

session_start();
    if(isset($_SESSION['login_user'])){
        $type = $_SESSION['login_type'];
        if($type == "Budget"){
            header('WWW-Authenticate: Basic realm="Restricted Section"');
            header('HTTP/1.0 401 Unauthorized');
            die (header('location: reserve'));
        }
        if($type == "ASAB"){
            header('WWW-Authenticate: Basic realm="Restricted Section"');
            header('HTTP/1.0 401 Unauthorized');
            die (header('location: admin/admin'));
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
    <script src="jquery-3.2.1.min.js"></script>
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fau.css" rel="stylesheet">
    <script src="js/addAnotherRev.js"></script>
    <script src="js/revTotals.js"></script>
    <script src="js/textcount.js"></script>
    <!-- Custom styles for this template -->
    <style>
        .extrapadding{
            padding-right: 25%;
        }
      body {
        padding-top: 54px;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }
        a:hover{
            text-decoration: none;
            color: #0056B3;
            transition: 0.5s;
        }
        
        .better-cursor:hover{
            cursor: pointer;
        }
        
        

    </style>
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-fau fixed-top">
      <div class="container">
        <a class="navbar-brand" href="login.php">Request Forms</a>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h1 class="mt-5">Login</h1>
            <div class="row">
                <p class="lead">
                    This program was built under the assumption logging in would be handled by a unified login system. If you would like to see a sample of a registration/login, please see my <a href="http://lamp.cse.fau.edu/~hsimon2015/p7/" target="_blank">image hosting site project.</a>
                </p>
            </div>
        </div>
      </div>
            <div class="row">
                <div class="col-lg-6">
                    <form action="loginreviewer.php">
                        <button type="submit" class ="btn btn-blue btn-block better-cursor">Reviewer</button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <form action="loginsubmitter.php">
                        <button type="submit" class ="btn btn-blue btn-block better-cursor">Submitter</button>
                    </form>
                </div>
        </div>
        <br />
        <hr>
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Testing Functions</h1>
                <div class="row">
                <p class="lead">
                    To further test this program, I've given access to create extra users and organizations. These forms are <em>not</em> tested for security and are most likely expoitable. These functions are for testing purposes only, so they were not built with security in mind.
                </p>
            </div>
            </div>
        </div>
        <div class="row">
                <div class="col-lg-4">
                    <form action="test/addorg.php">
                        <button type="submit" class ="btn btn-blue btn-block better-cursor">Add Organization</button>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form action="test/adduser.php">
                        <button type="submit" class ="btn btn-blue btn-block better-cursor">Add User</button>
                    </form>
                </div>
                <div class="col-lg-4">
                    <form action="test/customuser.php">
                        <button type="submit" class ="btn btn-blue btn-block better-cursor">Custom User Login</button>
                    </form>
                </div>
            </div>
    </div>
      <?php $db->close(); ?>
  </body>

</html>