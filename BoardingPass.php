
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//connect to the database
session_start();
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
        <link rel="stylesheet" type="text/css" href="style_employee.css" /> 
    </head>
   <body>
       <div class="header">
            <div class="container">
                <a href="StationAttendant.php"><div class="logo">
                    <img src="airplane.png"/>
                </div>
                <div class="name">
                    <center><h1>BASA Airline</h1></center>	
                    
                </div></a>
                <div class="login"> 
                   <ul>
                        <li><a href="accountInfo_stationattendant.php">My Account</a></li>
                        <li> | </li>
                        <li> <form method="POST" action="#"><input ID="signOutLink" type ="submit" name ="SubmitOut" value ="Sign Out"/>
                            </form></li>
                    </ul>
                    </div>
                <div class="menu">
                    <div class="container">
                    <ul>
                        <li><a href="StationAttendant.php">Home</a></li>
<!--                        <li><a href="aboutus.php">About Us</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>-->
                    </ul>
                    </div>
                </div>
            </div>
       </div>
       
        
       <div class ="content">
           <div class="container">
              
               <!--MY CODE STARTS HERE -->
                   <div class="signInOrUp">
                       <h1 ID="boldcenter"><br>Check In</h1> 
                       
                       <div ID="signInContents">
                           
                           <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                           <form method="POST" action="#">
                           <p ID="userpass"> Passport ID </p> <input ID="inputblock" type="text" name="Passport" required maxlength=9/> <br> <br>
                           <p ID="userpass"> Number of Bags </p><input ID="inputblock" type="text" name="Bags" required maxlength=1 /> <br><br>
                           <br>
                           
                          <input class="button" type="submit" name="passportID" value="Submit"/> 
                      </div>
                       </form> 
                           <?php 
                           
                           //session_unset();
                          
                           if(isset($_POST['passportID'])){
                           
                           $passport = filter_input(INPUT_POST, 'Passport');
                           //echo ' <script type="text/javascript"> alert("'.$passport.'"); </script>';
                           $Ticket = $_SESSION['TN'];
                           
                            $queryBag = "SELECT CustomerEmail FROM travels_on WHERE TicketNumber = '$Ticket'";
                            $queryBag2 = mysqli_query($con, $queryBag);
                            $resultSeat = mysqli_fetch_array($queryBag2);
                            $email = $resultSeat['CustomerEmail'];
                            //echo ' <script type="text/javascript"> alert("'.$email.'"); </script>';
                            $update = "UPDATE customer SET Passport = '$passport' WHERE Email = '$email'";
                            $queryUpdate = mysqli_query ($con, $update);
                            //$queryResult = mysqli_fetch_array($queryUpdate);
//                             if (!$check1_res) {
//                                   printf("Error: %s\n", mysqli_error($con));
//                                   exit();
//                                  }
                           
                            //echo ' <script type="text/javascript"> alert("'.$email.'"); </script>';
                           //echo ' <script type="text/javascript"> alert("'.$passport.'"); </script>';
                           //echo ' <script type="text/javascript"> alert("'.$Ticket.'"); </script>';
//                           $Ticket = $_SESSION['TN'];
//                           echo ' <script type="text/javascript"> alert("'.$Ticket.'"); </script>';
//                         
                           $bagID = filter_input(INPUT_POST, 'Bags');
                           $_SESSION['BagsNum'] = $bagID;
                           
                           //$_SESSION['passport'] = $passport;
                           
                           header("Location:BoardingPassPrint.php");
                           //session_destroy();
                           exit;
                           
                           }
                           ?>
                           
                   </div>
               </div>            
             
           
           
       </div>
       
       
		
        <?php
        
        ?>
    </body> 
</html>

