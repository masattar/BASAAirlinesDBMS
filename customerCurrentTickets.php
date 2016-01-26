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

//otherwise read the user email into a variable 
$cusEmail =  $_SESSION['userEmail'];

$strSQLName = "SELECT Name FROM customer WHERE Email='$cusEmail'";
$queryName = mysqli_query($con, $strSQLName);  //submit query to the db
$resultName = mysqli_fetch_array($queryName); //should contain a single element (the customer name)

$cusName = $resultName['Name']; //replace this name with the one used to create the ticket

//use TRAVELS_ON table to access the tickets bought by the customer and the flight information as well
$strSQL = "SELECT * "
        . "FROM travels_on AS T, flight AS F "
        . "WHERE T.CustomerEmail='$cusEmail' AND F.FlightNumber=T.FlightNum ";
$queryCus = mysqli_query($con, $strSQL);  //submit query to the db



$ticket_array = array(); // a 2D array to hold the table
$i = 0;

//store the tickets in the 2D array
while($resultCus=mysqli_fetch_array($queryCus))
{
    //travels_on stuff
    $ticket_array[$i]['FlightNum']=$resultCus['FlightNum'];
    $ticket_array[$i]['TicketNumber']=$resultCus['TicketNumber'];
    $ticket_array[$i]['SeatNumber']=$resultCus['SeatNumber'];
    
    //flight stuff
    $ticket_array[$i]['Price']=$resultCus['Price'];
    
    $ticket_array[$i]['DepAPCode']=$resultCus['DepartureAirportCode'];
    $ticket_array[$i]['DepGateNumber']=$resultCus['DepartureGateNumber'];
    $ticket_array[$i]['DepTime']=$resultCus['DepartureDateTime'];
    
    $ticket_array[$i]['ArrivalAPCode']=$resultCus['ArrivalAirportCode'];
    $ticket_array[$i]['ArrivalGateNumber']=$resultCus['ArrivalGateNumber'];
    $ticket_array[$i]['ArrivalTime']=$resultCus['ArrivalDateTime'];
    
    
    //departure & arrival airport codes
    $depCode = $resultCus['DepartureAirportCode'];
    $arrivalCode = $resultCus['ArrivalAirportCode'];
    
    //airport stuff 
    $airSQL = "SELECT A.Location AS DepLoc, B.Location AS ArrivalLoc "
            . "FROM airport AS A, airport AS B "
            . "WHERE A.AirportCode = '$depCode' AND B.AirportCode='$arrivalCode' ";
    
    $queryAir = mysqli_query($con, $airSQL);  //submit query to the db     
    $resultAir=mysqli_fetch_array($queryAir); //should be a single row containing the departure and arrival locations
    
    $ticket_array[$i]['DepLoc']=$resultAir['DepLoc'];
    $ticket_array[$i]['ArrivalLoc']=$resultAir['ArrivalLoc'];
    
    
    $i++;
}


if (isset($_POST['Remove'])) //if user presses the Remove button
{
     $remTicketID = filter_input(INPUT_POST, 'TicketID');
     
     $strSQLTixDel = "DELETE FROM travels_on "
             . "WHERE TicketNumber = '$remTicketID'";
     
     $queryTixDel = mysqli_query($con, $strSQLTixDel);  //submit query to the db
     
     header("Location: customerCurrentTickets.php");//refresh the page
    
     
     
}

//$_POST['index'] = $i; //send this index through the post array to be read below and output to the screen
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
<!--                    <p><a href="index.php"> Sign Out </a></p>-->
                    <!--maybe replace this code back to original-->
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
                        <li><div class="currentLink">My Tickets</div></li>
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
               <div class="box">
               <h1 ID="boldcenter"> My Tickets </h1>
               
               <form method="POST"> 
                   <p ID="ticketFieldID"> Ticket ID: </p>
                           <select ID="inputblockTicketID" name="TicketID" required>  
                               <option value="">Please select</option>
                               <?php 
                               
                               //select all the locations possible
                               $strSQLTix = "SELECT T.TicketNumber "
                                       . "FROM travels_on AS T "
                                       . "WHERE T.CustomerEmail = '$cusEmail'";
                               $queryTix = mysqli_query($con, $strSQLTix);  //submit query to the db
                               
                               while($resultTix= mysqli_fetch_array($queryTix)) 
                               {
                                   
                                   echo '<option value= "'.$resultTix['TicketNumber'].'">' .$resultTix['TicketNumber'].'</option>';
                               }
                                
                               ?>
                               
                           </select> 
                   
                    <input class="removeButton" type ="submit" name ="Remove" value ="Remove"/>
               </form>
               
               <!--<div class="ticketdisplay">-->
                   <ol>
                       <?php
                       
                       $x = 0;
                       while($x < $i) //iterate through the array created above
                       {
                           echo '<li>'.'<div class="indvticket">'.
                                   '<div ID="tixSectionHead">'.'<div ID="tixAttrHead">'. "Name: ".'</div> '.$cusName .'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'."Ticket #: ".'</div>'.$ticket_array[$x]['TicketNumber'].'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'."Price: ".'</div>'."$".$ticket_array[$x]['Price'].'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Flight #: ".'</div>'.$ticket_array[$x]['FlightNum'].'</div>'. 
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Seat #: ".'</div>'.$ticket_array[$x]['SeatNumber'].'</div>'. '<br>'.'<br>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Departure Location: ".'</div>'.$ticket_array[$x]['DepLoc']." (".$ticket_array[$x]['DepAPCode'].")".'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Departure Time: ".'</div>'.substr($ticket_array[$x]['DepTime'],0,16).'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Departure Gate #: ".'</div>'.$ticket_array[$x]['DepGateNumber'].'</div>'. '<br>'.'<br>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Arrival Location: ".'</div>'.$ticket_array[$x]['ArrivalLoc']." (".$ticket_array[$x]['ArrivalAPCode'].")".'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Arrival Time: ".'</div>'.substr($ticket_array[$x]['ArrivalTime'],0,16).'</div>'.
                                   '<div ID="tixSection">'.'<div ID="tixAttr">'. "Arrival Gate #: ".'</div>'.$ticket_array[$x]['ArrivalGateNumber'].'</div>'.
                                   '</div>'.'</li>';
                           $x++;
                       }
                       
                       //Might need to change this so it deletes when tickets are added
                       //but also might work itself out
                       if($i <= 0)
                       {
                           echo '<h1 ID="tixEmpty">'. "You currently have no tickets" . '</h1>';
                       }
                       
                       ?>
                       
                   </ol>
               <!--</div>-->
               
               
               
               
               
               
               
               
               
               
               
               
           </div>
           
           
       </div>

    </body> 
</html>

