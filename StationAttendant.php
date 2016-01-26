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
                        <li><div class="currentLink">Home</div></li>
                        
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
               
               <div class ="left">
                    <div class="signInOrUp">
                       <h1 ID="boldcenter"><br>Check Flight</h1> 
                       
                       <div ID="signInContents">
                           
                           <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                           <form method="POST" action="#">
                           <p ID="userpass"> Flight Number </p> <input ID="inputblock" type="text" name="FlightNumber" required maxlength=6/> <br> <br>
                           <!--<p ID="userpass"> Password </p><input ID="inputblock" type="password" name="Password" required /> <br><br>-->
                           <br>
                           
                          <input class="button" type="submit" name="flightEnter" value="Enter"/> 
                      </div>
                       </form> 
                           <?php 
                           if(isset($_POST['flightEnter']))
                               {
                               
                                $FlightNumber = filter_input(INPUT_POST, 'FlightNumber');
                                $queryFlight = "SELECT FlightNumber FROM flight WHERE FlightNumber = '$FlightNumber'";
                                $query = mysqli_query($con, $queryFlight);
                                $result1 = mysqli_fetch_array($query);

                                if($result1 != NULL)
                                {
                                    $_SESSION['FlightNumber'] = $FlightNumber;
                                    header("Location:FlightList.php");
                                }
                                else
                                {
                                    echo ' <script type="text/javascript"> alert("Flight Number is invalid!"); </script>';

                                }
                                //make query to check the values
                                
                                
                               // echo $_SESSION['value'];
                                //echo '<br /><a href="FlightList.php">page 2</a>';

                               
                               //Stuff here for sign in
                                //$FlightNumber = filter_input(INPUT_POST, 'FlightNumber');
                                //include 'FlightList.php';
                                //header("Location:FlightList.php");
                                
                           
                               }
                           //Read username & password into variable 
//                           <!--$passwordSignIn = filter_input(INPUT_POST, 'Password');-->
                           
                           
                           // echo $username;
                           // echo $password;
                           // check whether username and password are valid (also that they're not empty)
                           // SELECT the eid w/ that email from the customer table
                           // SELECT all eids w/ that password from the cutomer table
                           // Check that the username eid is in the password eid table
                           // If result is NOT NULL then --> PASSES --> go to next page
                           // Otherwise (username eid is not in password table) --> FAILS --> display error message
                           // DO IT W/ FOLLOWING CODE
                           // if(/* Your conditions */){
                            // redirect if fulfilled
                            // header("Location:nxtpage.php");
                           // }
                           // else{
                                //some another operation you want
                           // }
                           
                           ?>
                   </div>
               </div>    
               
               <!--ticket number stuff-->
               <div class ="right">
                    <div class="signInOrUp">
                       <h1 ID="boldcenter"><br>Check In Customer</h1> 
                       
                       <div ID="signInContents">
                           
                           <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                           <form method="POST" action="#">
                           <p ID="userpass"> Ticket Number </p> <input ID="inputblock" type="text" name="TicketNumber" required maxlength=5/> <br> <br>
                           <!--<p ID="userpass"> Password </p><input ID="inputblock" type="password" name="Password" required /> <br><br>-->
                           <br>
                           
                          <input class="button" type="submit" name="ticketEnter" value="Enter"/> 
                      </div>
                       </form> 
                           <?php 
                           if(isset($_POST['ticketEnter'])){
                               //Stuff here for sign in
                           $TicketNumber = filter_input(INPUT_POST, 'TicketNumber'); //Read username & password into variable 
                           $queryTicket = "SELECT TicketNumber FROM travels_on WHERE TicketNumber = '$TicketNumber'";
                           $query = mysqli_query($con, $queryTicket);
                           $result = mysqli_fetch_array($query);
                           
                           $_SESSION['TN'] = $result['TicketNumber'];
                           
                           
                           if($result != NULL)
                           {
//                              echo ' <script type="text/javascript"> alert("'.$TicketNumber.'"); </script>';
                               header("Location:BoardingPass.php");
                           }
                           else
                           {
                               echo ' <script type="text/javascript"> alert("Ticket not found!"); </script>';

                           }
                           }
                           
                           
                         
                          // $_SESSION['value'] = $TicketNumber;
//                           <!--$passwordSignIn = filter_input(INPUT_POST, 'Password');-->
                           
                           
                           // echo $username;
                           // echo $password;
                           // check whether username and password are valid (also that they're not empty)
                           // SELECT the eid w/ that email from the customer table
                           // SELECT all eids w/ that password from the cutomer table
                           // Check that the username eid is in the password eid table
                           // If result is NOT NULL then --> PASSES --> go to next page
                           // Otherwise (username eid is not in password table) --> FAILS --> display error message
                           // DO IT W/ FOLLOWING CODE
                           // if(/* Your conditions */){
                            // redirect if fulfilled
                            // header("Location:nxtpage.php");
                           // }
                           // else{
                                //some another operation you want
                           // }
                           
                           ?>
                   </div>
               </div>      
             
           
           
       </div>
		
        <?php
        
        ?>
    </body> 
</html>


<?php
?>



