<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    $con = mysqli_connect("localhost","root","","basaairline") or die("Some error occured during connection " . mysqli_error($con));
      
if (isset($_POST['SubmitOut'])) //if user presses the SIGN OUT button
{
    session_destroy(); //end session
    header("Location: index.php"); //redirect to Home page
    exit;
}


if (isset($_POST['updateFlight'])) {
    
    $flightNum = filter_input(INPUT_POST, 'FlightNumberBoxE');
    
    $status = filter_input(INPUT_POST, 'FliStatus');
    $price = filter_input(INPUT_POST, 'FliPrice');
    
        
    $strSQLEdit = "UPDATE flight SET Status = '$status', Price = '$price' WHERE FlightNumber='$flightNum'";
    $queryEdit = mysqli_query($con, $strSQLEdit);
    
    if ($queryEdit == true) {
        header("Location:viewflights.php");
    }
    else {
        echo ' <script type="text/javascript"> alert("Employee does not exist. Please try again."); </script>';
    }
    
    }
    



    if(isset($_POST['addFlight'])){
        
        $FlightNum = rand(1,999);
    $FlightNumYnique = true; //assume the ticket is initially unique
                       
                       
                       while(true) //while true loop
                       {
                           $strSQLflightnum = "SELECT FlightNumber "
                               . "FROM flight ";
                           
                           $queryFlightNum = mysqli_query($con, $strSQLflightnum); 
                           
                           while($resultFlightNum = mysqli_fetch_array($queryFlightNum)) //go through all the ticket numbers that exist in the db
                           {
                               if($resultFlightNum['FlightNumber'] == $FlightNum){ //if at any point that ticket number already exists
                                   $FlightNumYnique = false; //signal that the ticket already exists
                                   $FlightNum = rand(10000, 99999); //generate new random 5-digit number (to try again)
                                   break; //found a match so break out of the loop 
                               }
                           }
                           
                           if($FlightNumYnique) // if the ticket is still unique at this point it's good 2 go
                           {
                               break; //break out of the true loop
                           }
                           //otherwise start the loop all over again
                       }
        
        
        $Status = "ON TIME";
        $Price = filter_input(INPUT_POST, 'Price');
        $RegistrationNumber = filter_input(INPUT_POST, 'RegNum');
        $PilotID = filter_input(INPUT_POST, 'PilotID');
        $DepartureCode = filter_input(INPUT_POST, 'DepartCode');
        $DepartureGate = filter_input(INPUT_POST, 'DepartGate');
        $DepartureTime = filter_input(INPUT_POST, 'DepartTime');
        $ArrivalCode = filter_input(INPUT_POST, 'ArriveCode');
        $ArrivalGate = filter_input(INPUT_POST, 'ArriveGate');
        $ArrivalTime = filter_input(INPUT_POST, 'ArriveTime');
                            
        $strSQLInsert = "INSERT INTO flight VALUES ('$FlightNum', '$Status', '$Price', '$RegistrationNumber', "
                . "'$PilotID', '$DepartureCode', '$DepartureGate', '$DepartureTime', '$ArrivalCode', '$ArrivalGate', '$ArrivalTime')";
        $queryInsert = mysqli_query($con, $strSQLInsert);
            
      if ($queryInsert == true) {
        header("Location:viewemployees.php");
    }
    else {
        echo ' <script type="text/javascript"> alert("Failed"); </script>';
    }
        header("Location:viewflights.php");
        exit;
    }
                        
    if(isset($_POST['delFlight'])){
        $FlightNum = filter_input(INPUT_POST, 'FlightNo');
                                               
        $strSQLDelete =  "DELETE FROM flight WHERE flight . FlightNumber = '$FlightNum'";
        $queryDelete = mysqli_query($con, $strSQLDelete);
//      if (!$check1_res) {
//          printf("Error: %s\n", mysqli_error($con));
//          exit();
//      }                          
        header("Location:viewflights.php");
        exit;
    }
                 
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BASA Airline</title>
        <link rel="stylesheet" type="text/css" href="style_manager_flight.css" /> 
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
                            <li><a href="managerhome.php">Home</a></li>
                            <li><a href="viewemployees.php">Employees</a></li>
                            <li><div class="currentLink">Flights</div></li>
                            <li><a href="viewplanes.php">Airplanes</a></li>
                        </ul>
                    </div>
                </div>
            </div>       
        </div>
        <div class ="content">
            <div class="bigcontainer">
                <div class="box">
                <h1><center> Flights</center></h1>
                <br>
                <center><div class="tableHeader">
                <ul class="tHeader">
                    <li class="smallcolumn">Flight<br>#</li>
                    <li class="column">Status</li>  
                    <li class="column">Airplane <br>Reg#</li>
                    <li class="column">Pilot Name</li>  
                    <li class="smallcolumn">FROM</li>
                    <li class="smallcolumn">Gate </li>
                    <li class="column">Depart. Date</li>  
                    <li class="smallcolumn">TO </li>  
                    <li class="smallcolumn"> Gate </li>
                    <li class="column">Arriv. Date</li> 
             
                </ul><br></div></center>
                      
                <div class="flightList">
                    <?php
                    $strSQL = "SELECT * "
                            . "FROM flight ";
                    $queryFlight = mysqli_query($con, $strSQL);
                    $pilot = "SELECT * FROM flight, employee WHERE PilotEID = eid";
                    $pilotQ = mysqli_query($con,$pilot);
                    $resultPilot = mysqli_fetch_array($pilotQ);
                    while($resultFlight = mysqli_fetch_array($queryFlight)){
                        echo "<div class = \"tcolumn\">"; 
                        echo "<li class=\"smalltuplecolumn\">". $resultFlight['FlightNumber'] . "</li> ";
                        echo "<li class=\"tuplecolumn\">". $resultFlight['Status'] . "</li> ";
                        echo "<li class=\"tuplecolumn\">". $resultFlight['AirplaneRegistrationNum']. "</li> " ;
                        echo "<li class=\"tuplecolumn\">". $resultPilot['Name'] . "</li> ";
                        echo "<li class=\"smalltuplecolumn\">". $resultFlight['DepartureAirportCode']. "</li> ";
                        echo "<li class=\"smalltuplecolumn\">". $resultFlight['DepartureGateNumber']. "</li> ";
                        echo "<li class=\"tuplecolumn\">". substr($resultFlight['DepartureDateTime'],0,16). "</li> ";
                        echo "<li class=\"smalltuplecolumn\">". $resultFlight['ArrivalAirportCode']. "</li>" ;
                        echo "<li class=\"smalltuplecolumn\">". $resultFlight['ArrivalGateNumber']. "</li>" ;
                        echo "<li class=\"tuplecolumn\">". substr($resultFlight['ArrivalDateTime'],0,16). "</li> <br/>";
                        echo "</div>";
                        echo"<br>";
                           echo"<br>";
//                       
                    }
                    ?>
                </div>
                <br>
                    <h2>Add Flight</h2> 
                
                        <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                         <ul class="flightAttributes">
                        <form method="POST" action="#">
                            
                           
                             <!--<li class="label"> Flight Number <br><input ID="inputblock" type="text" name="FlightNo" required maxlength="6"/>  </li>
                             <li class="label"> Status<br>  <input ID="inputblock" type="text" name="Stat" required maxlength="12"/> </li>-->
                            <li class="label"> Airplane Registration #  <br><input ID="inputblock" type="text" name="RegNum" required maxlength="6"/>  </li>
                             <li class="label"> Pilot EID <br> <input ID="inputblock" type="text" name="PilotID" required maxlength="8"/>  </li>
                            <li class="label"> Price <br> <input ID="inputblock" type="text" name="Price" required maxlength="6"/>  </li>
                             <li class="label"> Departure Airport Code <br><input ID="inputblock" type="text" name="DepartCode" required maxlength="3"/>  </li>
                             <li class="label"> Departure Gate Number <br> <input ID="inputblock" type="text" name="DepartGate" required maxlength="3"/> </li>
                             <li class="label"> Departure Date & Time <br> <input ID="inputblock" type="datetime-local" name="DepartTime"/> </li>
                             <li class="label"> Arrival Airport Code <br> <input ID="inputblock" type="text" name="ArriveCode" required maxlength="3"/>  </li>
                             <li class="label"> Arrival Gate Number <br> <input ID="inputblock" type="text" name="ArriveGate" required maxlength="3"/>  </li>
                             
                            
                             
                             <li class="label"> Arrival Date & Time <br> <input ID="inputblock" type="datetime-local" name="ArriveTime"/>  </li>
                             
                             <li class="label"><br> <input class="signButton" type="submit" name="addFlight" value="Add"/>
                                </li>
                                                            
                            </form> </ul>
                    
                        <br><br><br>  <br><br><br><br>
                        <br>
                    <h2>Remove Flight</h2>
                
                    
                      
                        <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                        
                        <form method="POST" action="#">
                        <ul class="flightAttributes">
                            <li class="label"> Flight Number <br> <input ID="inputblock" type="text" name="FlightNo" required maxlength="6"/> </li><br>
                            
                            <li class="label"> <input class="signButton" type="submit" name="delFlight" value="Remove">
                            </li>
                        </ul>
                        </form> 
                        <br><br>
                        
                        <h2>Edit Flight</h2>
                <div class="addremove">
                    <ul class="flightAttributes">
                    <form method ="POST" >  
                        <li class="label">Flight Number <br> <input ID="inputblock" type="text" name="FlightNumberBoxE" maxlength="8" required/></li>
                        <li class="label">Status <br> <input ID="inputblock" type="text" name="FliStatus" maxlength="8" required/></li>
                        <li class="label">Price <br> <input ID="inputblock" type="text" name="FliPrice" maxlength="8" required/></li>
                        <li class="label"><br><input class="signButton" type="submit" name="updateFlight" value="Update"/> </li>
                    </form> </div><br><br><br>
                        
                        <?php
                        
                        ?>
                
                
            
            </div>
        
        </div>
    
    </body> 
</html>