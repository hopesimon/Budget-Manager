<?php
    echo "<!DOCTYPE HTML>
        <html>
            <head>
            </head>
            <body>
                <p align='center'>Apologies for lack of CSS, but this is just a test function!</p>
                <h1>We only require 3 inputs to create a new user:<br /><ol><li>Name<ul><li>Just the name of the user</li><li>Max. 30 characters</li></ul></li><li>Email<ul><li>The email, excluding @domain.com</li><li>I have no security to handle this test function! Remember, this was built so that logins would be handled by an external source.</li><li>If you want to add @domain.com, I won't stop you</li></ul></li><li>User Type<ul><li>Either ASAB or Budget</li><li>This will automatically make the type Budget, since ASAB is an admin and all admins see the same features.</li></ul></li></ol></h1>
                <div align='center'>
                    <form action='useradd.php' method='post'>
                    <input align='center' style='width: 30%; height:20px; font-size:12pt; text-align:center;' type='text' name='my_name' placeholder='Name' maxlength='30'></input>
                    <br />
                    <br />
                    <input align='center' style='width: 30%; height:20px; font-size:12pt; text-align:center;' type='text' name='my_email' placeholder='FAU Email' maxlength='140'></input>
                    <br />
                    <br />
                    <input type='submit' style='width:10%; height:5%; font-size:12pt; background-color:red; color:white; border-radius:5px;'></input>
                    </form>
                </div>
            </body>
        </html>";
?>