<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
  
if (isset($_POST['SubmitOut'])) //if user presses the SIGN OUT button
{
    session_destroy(); //end session
    header("Location: index.php"); //redirect to Home page
    exit;
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BASA Airline</title>
        <link rel="stylesheet" type="text/css" href="style_manager_home.css" /> 
    </head>
    <body>
        <div class="header">
            <div class="container">
                <a href="managerhome.php">
                    <div class="logo">
                        <img src="airplane.png"/>
                    </div>
                    <div class="name">
                        <center><h1>BASA Airline</h1></center>	
                    </div>
                </a>
                <div class="login"> 
                    <p><a href="accountinfo.php">My Account</a> | <a href="index.php"> Sign Out </a>
                </div>
                <div class="menu">
                    <div class="container">
                    <ul>
                        <li><div class="currentLink"><b>Home</b></div></li>
                        <li><a href="viewemployees.php">Employees</a></li>
                        <li><a href="viewflights.php">Flights</a></li>
                        <li><a href="viewplanes.php">Airplanes</a></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
       
        <div class ="content">
            <div class="container">
                <center><br><br><br>
                <div class="managerButtons">
                    <a href="viewemployees.php"><div class="viewButton"> <br><h2>Manage Employees</h2></div></a>
                    <a href="viewflights.php"><div class="viewButton"> <br><h2>Manage Flights</h2></div></a>
                    <a href="viewplanes.php"><div class="viewButton"> <br><h2>Manage Airplanes</h2></div></a>
                   </div>
                </center>
            </div>
        </div>
        <?php
        
        ?>
    </body> 
</html>
