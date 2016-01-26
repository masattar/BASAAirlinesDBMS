

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
        <div class="container">
            <div class="content">
                   
            <h1 id="Text"> </h1> <br>
            <h1 id="Text"> </h1> <br>
            <h1 id="Text"> </h1> <br>
<!--            <br><br><br>-->
            
<div class="box2"><div>
            <br><ul class="flightlist">
            <li class="half"><h1 id="Text">Customer Name</h1> <?php
            $Ticket = $_SESSION['TN'];
//            echo $Ticket;
            // echo ' <script type="text/javascript"> alert("'.$Ticket.'"); </script>';
            $queryBag = "SELECT CustomerEmail FROM travels_on WHERE TicketNumber = '$Ticket'";
            $queryBag2 = mysqli_query($con, $queryBag);
            $resultSeat = mysqli_fetch_array($queryBag2);
            $email = $resultSeat['CustomerEmail'];
            $queryCus = "SELECT Name FROM customer WHERE Email = '$email'";
            $query = mysqli_query($con, $queryCus);
            $result = mysqli_fetch_array($query);
            
            echo $result['Name'];
            
            ?> </li></h1>
            <h1 id="Text">Luggage ID </h1>
             <div class="luggagelist">
              <?php
            
//            $queryBag = "SELECT Email FROM customer WHERE Passport = '987654321'";
//            $query = mysqli_query($con, $queryBag);
//            $result = mysqli_fetch_array($query);
//            $email = $result['Email'];
            
//            $queryBag2 = "SELECT LuggageID FROM luggage WHERE CustomerEmail = '$email'";
//            $query = mysqli_query($con, $queryBag2);
//            $result = mysqli_fetch_array($query);
//            echo $result['LuggageID'];
              $email;
              $bagNUM = $_SESSION['BagsNum'];
              for ($count = 0; $count < $bagNUM; $count++)
              {
                  $LuggageID = rand(1000,9999);
                  $insert = "INSERT INTO luggage VALUES ('$LuggageID', '$email')"; 
                  $queryInsert = mysqli_query($con, $insert);
                  echo $LuggageID;
                  echo "<br>";
              }
            
            //echo $ID;
            
            ?> 
           </div>      
            </h1> </li>
            <li class="half"><h1 id="Text">Flight Number</h1><?php
            $queryDep = "SELECT FlightNum FROM travels_on WHERE CustomerEmail = '$email'";
            $query = mysqli_query($con, $queryDep);
            $result = mysqli_fetch_array($query);
            $FlightNum = $result['FlightNum'];
            echo $FlightNum;
            ?></li>
            <li class="half"><h1 id="Text">Seat Number</h1><?php 
            //start_session();
            //$passportID = filter_input(INPUT_POST, 'Passport');
            $Ticket = $_SESSION['TN'];
//            echo $Ticket;
            // echo ' <script type="text/javascript"> alert("'.$Ticket.'"); </script>';
            $queryBag = "SELECT CustomerEmail FROM travels_on WHERE TicketNumber = '$Ticket'";
            $queryBag2 = mysqli_query($con, $queryBag);
            $resultSeat = mysqli_fetch_array($queryBag2);
            $email = $resultSeat['CustomerEmail'];
            
            $querySeat = "SELECT SeatNumber FROM travels_on WHERE CustomerEmail = '$email'";
            $querySeat2 = mysqli_query($con, $querySeat);
            $resultSeat = mysqli_fetch_array($querySeat2);
            
            echo $resultSeat['SeatNumber'];
            
            ?> </h1></li>
            
             <li class="half"><h1 id="Text">Departure </h1><?php
                           // $flightNumber = $_SESSION['value'];
                            //echo $flightNumber;
                            $queryDep = "SELECT FlightNum FROM travels_on WHERE CustomerEmail = '$email'";
            $query = mysqli_query($con, $queryDep);
            $result = mysqli_fetch_array($query);
            $FlightNum = $result['FlightNum'];
                            $status_query = "SELECT DepartureAirportCode, Location, DepartureGateNumber, DepartureDateTime FROM flight AS f, airport AS a WHERE FlightNumber = '$FlightNum' AND f.DepartureAirportCode = a.AirportCode";
                            $query = mysqli_query($con, $status_query);
                           /* if (!$check1_res) {
                                   printf("Error: %s\n", mysqli_error($con));
                                  exit();
                                  }*/
                            $result = mysqli_fetch_assoc($query);
                            $Dep = $result['DepartureAirportCode'];
                            echo "Location: " .$result['Location']. " (";
                            echo $Dep.") ". "<br>Gate Number: ".$result['DepartureGateNumber'] . "<br>Date: ". substr($result['DepartureDateTime'],0,16);
                            
                           
                          
                            ?></li></h1>
            <br>
             <li class="half"><h1 id="Text">Arrival </h1><?php
                           // $flightNumber = $_SESSION['value'];
                            //echo $flightNumber;
                            $queryDep = "SELECT FlightNum FROM travels_on WHERE CustomerEmail = '$email'";
            $query = mysqli_query($con, $queryDep);
            $result = mysqli_fetch_array($query);
            $FlightNum = $result['FlightNum'];
                            $status_query = "SELECT ArrivalAirportCode, Location, ArrivalGateNumber, ArrivalDateTime FROM flight AS f, airport AS a WHERE FlightNumber = '$FlightNum' AND f.ArrivalAirportCode = a.AirportCode";
                            $query = mysqli_query($con, $status_query);
                           /* if (!$check1_res) {
                                   printf("Error: %s\n", mysqli_error($con));
                                  exit();
                                  }*/
                            $result = mysqli_fetch_assoc($query);
                            $Dep = $result['ArrivalAirportCode'];
                            echo "Location: " .$result['Location']. " (";
                            echo $Dep.") ". "<br>Gate Number: ".$result['ArrivalGateNumber'] . "<br>Date: ". substr($result['ArrivalDateTime'],0,16);
                            
                           
                          
                            ?></li></h1>
            <br><br><br><li class="half">
            <br><br>
            </ul><br><br><br>
       <form method="POST" action="StationAttendant.php">
               <input class="button" type="submit" name="SignInBoarding" value="Back"/> 
       </form></div>
           </div>
        </body>
</html>