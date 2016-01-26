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
        <link rel="stylesheet" type="text/css" href="style_customer.css" /> 
    </head>
   <body>
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
                       <li><a href="customerHome.php">Home</a></li>  <!-- currently links to currentTickets (CHANGE to homepage)-->
                        <li><a href="customerCurrentTickets.php">My Tickets</a></li>
                        <li><a href="customerBookFlight.php">Book A Flight</a></li>
                        <li><a href="aboutusCustomer.php">About Us</a></li>
                        <li><div class="currentLink">Contact Us</div></li>
                    </ul>
                    </div>
                </div>
            </div>
       </div>
       
       <div class ="content">
           <div class="container">
                   <div class="box">
               <h1>Contact Us</h1>
                
                
               <p>You can contact us through any of the following emails:</p>
               <ul>
                    <li><b>Steven Joseph Hepburn</b>: sjhepburn95@outlook.com</li>
                    <li><b>Muhammad Abdullah Sattar</b>: masattar@ucalgary.ca</li>
                    <li><b>Arunalu Shashika Kariyawasam</b>: arunalukari@gmail.com</li>
                    <li><b>Bea Margarita Esguerra</b>: bea.esguerra@hotmail.com</li> 
               </ul>
               
               
           </div>
           
           
       </div>
		
        <?php
    
        ?>
    </body> 
</html>
