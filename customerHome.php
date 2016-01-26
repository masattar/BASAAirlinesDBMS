<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php 
session_start();
    //connect to the database
    $con = mysqli_connect("localhost","root","","basaairline") or die("Some error occured during connection " . mysqli_error($con));
    
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
        <link rel="stylesheet" type="text/css" href="style_customer_home.css" /> 
    </head>
   <body>
       <div class="tempbody">
       <div class="header">
            <div class="container">
                <a href="customerHome.php"><div class="logo">
                    <img src="airplane.png"/>
                </div>
                <div class="name">
                    <center><h1>BASA Airline</h1></center>	
                    
                </div></a>
                <div class="login"> 
                   <ul>
                        <li><a href="customerAccountInfo.php">My Account</a></li>
                        <li> | </li>
                        <li> <form method="POST" action="#"><input ID="signOutLink" type ="submit" name ="SubmitOut" value ="Sign Out"/>
                            </form></li>
                    </ul>
                    </div>
                <div class="menu">
                    <div class="container">
                    <ul>
                       <li><div class="currentLink"> Home</div></li>  <!-- currently links to currentTickets (CHANGE to homepage)-->
                        <li><a href="customerCurrentTickets.php">My Tickets</a></li>
                        <li><a href="customerBookFlight.php">Book A Flight</a></li>
                        <li><a href="aboutusCustomer.php">About Us</a></li>
                        <li><a href="contactusCustomer.php">Contact Us</a></li>
                    </ul>
                    </div>
                </div>
            </div>
       </div>
       
       <div class ="content">
           <div class="container">
               <center><br><br><br><br>
                <div class="customerButtons">
                    <br><br><br>
                    <a href="customerCurrentTickets.php"><div class="viewButton"> <br><h2>My Tickets</h2></div></a>
                    <a href="customerBookFlight.php"><div class="viewButton"> <br><h2>Book A Flight</h2></div></a>
                  
                   </div>
                </center>
               
           </div>
           
           
       </div>
		
        <?php
    
        ?>
       </div>
    </body> 
</html>
