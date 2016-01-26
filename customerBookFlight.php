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


//select all the customer's attributes from the db
$strSQL = "SELECT * FROM customer WHERE Email='$cusEmail'";
$queryCus = mysqli_query($con, $strSQL);  //submit query to the db
$resultCus = mysqli_fetch_array($queryCus); //should contain a single row w/ all the customer's attributes

//read in the customer's info
$cusName = $resultCus['Name'];
$cusBdate = $resultCus['Birthdate'];
$cusPass = $resultCus['Password'];



$strSQLFlight = "SELECT F.ArrivalDateTime, F.DepartureDateTime, F.FlightNumber, A.AirportCode AS DepCode, A.Location AS DepLoc, B.AirportCode AS ArrivalCode, B.Location AS ArrivalLoc "
            . "FROM flight AS F, airport AS A, airport AS B "
            . "WHERE A.AirportCode = F.DepartureAirportCode AND B.AirportCode=F.ArrivalAirportCode ";
$queryFlight = mysqli_query($con, $strSQLFlight);
//if (!$check1_res) {
//    printf("Error: %s\n", mysqli_error($con));
//    exit();
//}

$flight_array = array();
$i = 0;
while($resultFlight = mysqli_fetch_array($queryFlight))
{
    //store the flight info into an array
    $flight_array[$i]['FlightNumber'] = $resultFlight['FlightNumber'];
    $flight_array[$i]['DepCode'] = $resultFlight['DepCode'];
    $flight_array[$i]['DepLoc'] = $resultFlight['DepLoc'];
    $flight_array[$i]['ArrivalCode'] = $resultFlight['ArrivalCode'];
    $flight_array[$i]['ArrivalLoc'] = $resultFlight['ArrivalLoc'];
    $flight_array[$i]['ArrivalDateTime'] = $resultFlight['ArrivalDateTime'];
    $flight_array[$i]['DepDateTime'] = $resultFlight['DepartureDateTime'];
    $i++;
}

$y = NULL; //before the button is pushed
//if user presses the 'Check Availability' button
if (isset($_POST['SubmitCheck'])) 
{
    $numTickets = filter_input(INPUT_POST, 'numTickets');
    $from = filter_input(INPUT_POST, 'From'); //from location
    
    
    $to = filter_input(INPUT_POST, 'To'); //to location
     
    
    $x = 0;
    $y = 0;
    $availableFlights = array(); //create a new array of available flights
    while($x < $i) //iterate through the array created above
    {
        $flightNum = $flight_array[$x]['FlightNumber'];
        //if the flight departs and arrives from the correct places
        if((strcmp($flight_array[$x]['DepLoc'], $from) == 0) && (strcmp($flight_array[$x]['ArrivalLoc'], $to) == 0)) 
        {
            $availableFlights[$y]['FlightNumber']= $flight_array[$x]['FlightNumber']; 
            $availableFlights[$y]['DepCode']= $flight_array[$x]['DepCode']; 
            $availableFlights[$y]['DepLoc']= $flight_array[$x]['DepLoc'];
            $availableFlights[$y]['ArrivalCode']= $flight_array[$x]['ArrivalCode']; 
            $availableFlights[$y]['ArrivalLoc']= $flight_array[$x]['ArrivalLoc'];
            $availableFlights[$y]['DepTime'] = $flight_array[$x]['DepDateTime'];
            $availableFlights[$y]['ArrivalTime'] = $flight_array[$x]['ArrivalDateTime'];
            $y++;
        }
        $x++;
        
    }
}

//if the submit button is pushed
if(isset($_POST['SubmitTicket'])) 
{
//    $numTickets = filter_input(INPUT_POST, 'numTickets');  
    $chosenFlightNum = filter_input(INPUT_POST, 'chooseFlight'); //read the flight number they chose (WILL ALWAYS EXIST)
    $numTix = filter_input(INPUT_POST, 'numTickets');
   
    //still need to do the same for number of tickets somehow 
    $_SESSION['chosenFlightNum'] = $chosenFlightNum; 
    $_SESSION['numTix'] = $numTix; 
    //redirect to summary page
    header("Location:customerTicketSummary.php");
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
               <!--INSERT MY CODE HERE -->
               <div class="box">
               <h1 ID="boldcenter"> Book A Flight </h1>
               <!--<div class="bookdisplay">-->
                   
                   <div ID='bookingContents'>
                       
                       <!--Customer's ticket info form-->
                       <form method="POST" action="#">
                           
                           
                           <p ID="ticketFields"> From: </p>
                           <select ID="inputblockTicketFrom" name="From" required>  
                               <option value="">Please select</option>
                               <?php 
                               
                               //select all the locations possible
                               $strSQLLoc = "SELECT DISTINCT A.Location "
                                       . "FROM Airport AS A";
                               $queryLoc = mysqli_query($con, $strSQLLoc);  //submit query to the db
                                //should contain a list of all locations that airports exist
                               
                               while($resultLoc = mysqli_fetch_array($queryLoc)) 
                               {
                                   
                                   echo '<option value= "'.$resultLoc['Location'].'">' .$resultLoc['Location'].'</option>';
                               }
                                
                               ?>
                               
                           </select> 
                           
                           <p ID="ticketFields"> To: </p>
                           <select ID="inputblockTicketFrom" name="To" required>  
                               <option value="">Please select</option>
                               <?php 
                               $queryLoc2 = mysqli_query($con, $strSQLLoc);
                               while($resultLoc2 = mysqli_fetch_array($queryLoc2)) 
                               {
                                   echo '<option value= "'.$resultLoc2['Location'].'">' .$resultLoc2['Location'].'</option>';
                               }
                               ?>
                               
                           </select>
                               
                               
                               <input class="checkButton" type ="submit" name ="SubmitCheck" value ="Check Availability"/> <br><br><br><br><br>
                       </form>
                       
                   </div>
               <!--</div>-->
               
               
               
               <div style="margin-top: 5px ; margin-bottom: 5px">
                <!--<h1 ID="boldcenter">Available Flights</h1>-->
               <center><div class="tableHeader">
               <ul class="headers"><li class="columnFN">Flight #</li>
                   <li class="columnDL">Departure Location</li>  
                   <li class="columnDT">Departure Time</li> 
                   <li class="columnAL">Arrival Location</li> 
                   <li class="columnAT">Arrival Time</li>  
               </ul></div></center>
               <div class ="employeeList">
                   <?php
                   $index = 0;
                   if($y == NULL)
                   {
                       echo "<h1 ID=\"flightsEmpty\">"."No flights match your specifications"."</h1>";
                   }
                   else{
                       while($index < $y) {
                       echo "<div class = \"tuple\">";
                       echo "<li class=\"tuplecolumnFN\">". $availableFlights[$index]['FlightNumber'] . " ";
                       echo "<li class=\"tuplecolumnDL\">".$availableFlights[$index]['DepLoc']. " " ;
                       echo "<li class=\"tuplecolumnDT\">".substr($availableFlights[$index]['DepTime'],0,16). " " ;
                       echo "<li class=\"tuplecolumnAL\">".$availableFlights[$index]['ArrivalLoc'];
                       echo "<li class=\"tuplecolumnAT\">".substr($availableFlights[$index]['ArrivalTime'],0,16)." <br/>";
                       
                       echo "</div>";
                       echo "<br>";
                       $index++;
                       
                   }
                       
                   }
                   
                   ?>
                   
               </div>
               
               
               
               </div>
               
               <!--<div class="bookdisplay2">-->
                   
                   <div ID='bookingContents2'>                
                       <form method="POST" action="#">
                           <p ID="ticketFields"> Number Of Tickets: </p> <input ID="inputCounterNum" value="<?php if(isset($_POST['numTickets'])){echo $numTickets;} ?>" type="number" name="numTickets" min="1" max = "10" step="1" required/> 
                           <p ID="ticketFields"> Flight #: </p>
                           <select ID="inputblockTicketFrom" name="chooseFlight" required> 
                                <option value="">Select from available flights</option>
                               <?php
                               $indexF = 0;
                               if($y == NULL){
                                   //do nothing
                               }
                               else{
                                   while($indexF < $y) {
                                       echo '<option value= "'.$availableFlights[$indexF]['FlightNumber'].'">' .$availableFlights[$indexF]['FlightNumber'].'</option>';
                                       $indexF++;
                                   }
                               }
                               ?>
                           </select>   
                          
                           
                           <input class="submitButton" type ="submit" name ="SubmitTicket" value ="Submit"/>
                       </form> 
                       
                   </div>
                   
               <!--</div>-->
               
               
               
               
               
               
           </div>
           
           
       </div>
	
    </body> 
</html>
