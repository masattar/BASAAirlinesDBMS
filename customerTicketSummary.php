
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
     //if (!$check1_res) {
//    printf("Error: %s\n", mysqli_error($con));
//    exit();
//}
    
if (isset($_POST['SubmitOut'])) //if user presses the SIGN OUT button
{
    session_destroy(); //end session
    header("Location: index.php"); //redirect to Home page
    exit;
}

//otherwise read the user email into a variable 
$cusEmail =  $_SESSION['userEmail'];
//select all the customer's attributes from the db
$strSQL = "SELECT * FROM customer WHERE Email='$cusEmail'";
$queryCus = mysqli_query($con, $strSQL);  //submit query to the db
$resultCus = mysqli_fetch_array($queryCus); //should contain a single row w/ all the customer's attributes

//read in the customer's info
$cusName = $resultCus['Name'];
$cusBdate = $resultCus['Birthdate'];
$cusPass = $resultCus['Password'];

$chosenFlightNum = $_SESSION['chosenFlightNum'];
$numTix = $_SESSION['numTix'];


$strSQLFlight = "SELECT *"
        . "FROM flight "
        . "WHERE FlightNumber = '$chosenFlightNum'";
$queryFlight = mysqli_query($con, $strSQLFlight); 

$resultFlight = mysqli_fetch_array($queryFlight);  //get the flight info (should be a SINGLE row -- 1D array)


    $depCode = $resultFlight['DepartureAirportCode'];
    $arrivalCode = $resultFlight['ArrivalAirportCode'];
    
    //airport stuff 
    $airSQL = "SELECT A.Location AS DepLoc, B.Location AS ArrivalLoc "
            . "FROM airport AS A, airport AS B "
            . "WHERE A.AirportCode = '$depCode' AND B.AirportCode='$arrivalCode' ";
    
    $queryAir = mysqli_query($con, $airSQL);  //submit query to the db     
    $resultAir=mysqli_fetch_array($queryAir); //should be a single row containing the departure and arrival locations
    
    $resultFlight['DepLoc']=$resultAir['DepLoc'];
    $resultFlight['ArrivalLoc']=$resultAir['ArrivalLoc']; //add onto flight info
    
    $flightAirplaneReg = $resultFlight['AirplaneRegistrationNum']; //the airplane registered to this flight
    //aeroplane information
    $planeSQL = "SELECT * "
            . "FROM airplane AS A "
            . "WHERE A.RegistrationNumber = '$flightAirplaneReg' ";
    
    $queryPlane= mysqli_query($con, $planeSQL);  //submit query to the db     
   
    $resultPlane=mysqli_fetch_array($queryPlane); //should be a single row containing the airplane specs
    
    $resultFlight['Capacity'] = $resultPlane['Capacity']; 
    $resultFlight['Model'] = $resultPlane['Model'];  //add to flight info



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
                        <li><a href="customerHome.php">Home</a></li> <!-- currently links to currentTickets (CHANGE to homepage)-->
                        <li><a href="customerCurrentTickets.php">My Tickets</a></li>
                        <li><div class="currentLink">Book A Flight</div></li>
                        <li><a href="aboutusCustomer.php">About Us</a></li>
                        <li><a href="contactusCustomer.php">Contact Us</a></li>
                    </ul>
                    </div>
                </div>
            </div>
       </div>
       
       <div class ="content">
           <div class="container">
               <div class="box">
               <h1 ID="boldcenter"> Order Summary </h1>
               
               
               <!--<div class="ticketdisplay">-->
                   <!--Display my tickets here (USE A LIST?)-->
                   <ol>
                   <?php 
                   $x = 0;
                   
                   //iterate the number of times needed to make the correct amt of tickets
                   while($x < $numTix){
                       
                       $ticketNum = rand(10000, 99999); // generate random 5-digit number
                       $ticketunique = true; //assume the ticket is initially unique
                       
                       
                       while(true) //while true loop
                       {
                           $strSQLTicketNum = "SELECT TicketNumber "
                               . "FROM travels_on ";
                           
                           $queryTicketNum = mysqli_query($con, $strSQLTicketNum); 
                           
                           while($resultTicketNum = mysqli_fetch_array($queryTicketNum)) //go through all the ticket numbers that exist in the db
                           {
                               if($resultTicketNum['TicketNumber'] == $ticketNum){ //if at any point that ticket number already exists
                                   $ticketunique = false; //signal that the ticket already exists
                                   $ticketNum = rand(10000, 99999); //generate new random 5-digit number (to try again)
                                   break; //found a match so break out of the loop 
                               }
                           }
                           
                           if($ticketunique) // if the ticket is still unique at this point it's good 2 go
                           {
                               break; //break out of the true loop
                           }
                           //otherwise start the loop all over again
                       }
                       
                       //at this point $ticketnum = a unique 5 digit number
                       
                       $seatTaken = true; //assume the seat number is already taken
                       
                       while($seatTaken) //search while the seat is already taken
                       {
                           $seatNumber = rand(1, $resultFlight['Capacity']);
                       
                           //check if seat is already taken on that flight
                           $snSQL = "SELECT SeatNumber "
                                . "FROM travels_on "
                                . "WHERE SeatNumber ='$seatNumber' AND " 
                                . "FlightNum = $chosenFlightNum";
                           
                           $querysn = mysqli_query($con, $snSQL);
                           $resultsn = mysqli_fetch_array($querysn); // is NULL if no seat like the one described exists
                           
                           if($resultsn == NULL){
                               //the seat isn't taken!
                               $seatTaken = false; //break out of the loop
                           }
                           //otherwise keep generating a random number and checking
                       }
                       
                       //now store ticket into database
                       $queryInsTix = "INSERT INTO travels_on VALUES ('$ticketNum', '$cusEmail', '$chosenFlightNum', '$seatNumber')";
                       $resultInsTix = mysqli_query($con, $queryInsTix); //ticket insertion was successful?
                       
                       //display ticket to the user
                       echo '<li>'.'<div class="indvticket">'.
                                   '<div ID="tixSectionHead">'.'<div ID="tixAttrHead">'. "Name: ".'</div> '.$cusName .'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'."Ticket #: ".'</div>'.$ticketNum.'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'."Price: ".'</div>'."$".$resultFlight['Price'].'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Flight #: ".'</div>'.$resultFlight['FlightNumber'].'</div>'. 
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Seat #: ".'</div>'.$seatNumber.'</div>'. '<br>'.'<br>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Departure Location: ".'</div>'.$resultFlight['DepLoc']." (".$resultFlight['DepartureAirportCode'].")".'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Departure Time: ".'</div>'.$resultFlight['DepartureDateTime'].'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Departure Gate #: ".'</div>'.$resultFlight['DepartureGateNumber'].'</div>'. '<br>'.'<br>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Arrival Location: ".'</div>'.$resultFlight['ArrivalLoc']." (".$resultFlight['ArrivalAirportCode'].")".'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Arrival Time: ".'</div>'.$resultFlight['ArrivalDateTime'].'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Arrival Gate #: ".'</div>'.$resultFlight['ArrivalGateNumber'].'</div>'.
                                   '</div>'.'</li>';
                       
                       
                       $x++;
                   }
                   
                   ?>
                   </ol>
               <!--</div>-->
               
               
               
               
               
               
               
               
               
               
               
               
               </div></div>
           
           
       </div>

    </body> 
</html>
