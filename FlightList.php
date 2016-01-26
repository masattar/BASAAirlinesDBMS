<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//connect to the database
    $con = mysqli_connect("localhost","root","","basaairline") or die("Some error occured during connection " . mysqli_error($con));
    session_start();  
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
       
       <!--FlightList code starts here-->
       
      <?php /*require_once 'StationAttendant.php'*/;?>
       <div class ="content">
           <div class ="container">
                <div class="box">
                    
                    <ul class="flightlist">
                        <li class="half"> <h1 id="Text">Flight Number</h1> 
                    <?php $flightNumber = $_SESSION['FlightNumber'];
                    echo $flightNumber;
                    ?></li>
                        <li class="half"> <h1 id="Text">Status</h1><?php
                            //$flightNumber = $_SESSION['value'];
                            //echo $flightNumber;
                            
                            $status_query = "SELECT Status FROM flight WHERE FlightNumber = '$flightNumber'";
                            $query = mysqli_query($con, $status_query);
//                            if (!$check1_res) {
//                                   printf("Error: %s\n", mysqli_error($con));
//                                   exit();
//                                  }
                            $result = mysqli_fetch_assoc($query);
                            $status = $result['Status'];
                            echo $status;
                            
                            ?></h1></li>
                        
                        <li class="half"> <h1 id="Text">Departure </h1><?php
                           // $flightNumber = $_SESSION['value'];
                            //echo $flightNumber;
                            
                            $status_query = "SELECT DepartureAirportCode, Location, DepartureGateNumber, DepartureDateTime FROM flight AS f, airport AS a WHERE FlightNumber = '$flightNumber' AND f.DepartureAirportCode = a.AirportCode";
                            $query = mysqli_query($con, $status_query);
                           /* if (!$check1_res) {
                                   printf("Error: %s\n", mysqli_error($con));
                                  exit();
                                  }*/
                            $result = mysqli_fetch_assoc($query);
                            $Dep = $result['DepartureAirportCode'];
                            echo "Location: " .$result['Location']. " (";
                            echo $Dep.") ". "<br>Gate Number: ".$result['DepartureGateNumber'] . "<br>Date: ". substr($result['DepartureDateTime'],0,16);
                            
                           
                          
                            ?></h1></li>
                
                        <li class="half"><h1 id="Text">Arrival </h1><?php
                           // $flightNumber = $_SESSION['value'];
                            //echo $flightNumber;
                            
                            $status_query = "SELECT ArrivalAirportCode, Location, ArrivalGateNumber, ArrivalDateTime FROM flight AS f, airport AS a WHERE FlightNumber = '$flightNumber' AND f.ArrivalAirportCode = a.AirportCode";
                            $query = mysqli_query($con, $status_query);
                           /* if (!$check1_res) {
                                   printf("Error: %s\n", mysqli_error($con));
                                  exit();
                                  }*/
                            $result = mysqli_fetch_assoc($query);
                            $Dep = $result['ArrivalAirportCode'];
                            echo "Location: " .$result['Location']. " (";
                            echo $Dep.") ". "<br>Gate Number: ".$result['ArrivalGateNumber'] . "<br>Date: ". substr($result['ArrivalDateTime'],0,16);
                            
                           
                          
                            ?></h1></li>
                        
                        
                        
                     <li class="half"> <h1 id="Text">Pilot</h1><?php
                            //$flightNumber = $_SESSION['value'];
                            //echo $flightNumber;
                            
                            $status_query = "SELECT Name FROM flight, employee WHERE FlightNumber = '$flightNumber' and eid = PilotEID";
                            $query = mysqli_query($con, $status_query);
//                            if (!$check1_res) {
//                                   printf("Error: %s\n", mysqli_error($con));
//                                   exit();
//                                  }
                            $result = mysqli_fetch_assoc($query);
                            $status = $result['Name'];
                            echo $status;
                            
                            ?></h1></li>
                     
                     
                        <li class="full"><h1 id="Text">Flight Attendants</h1>
                        <div class="list">
                        <?php
                      
                            //$flightNumber = $_SESSION['value'];
                            $attendant_query = "SELECT Name FROM works_in, employee WHERE FlightNum = '$flightNumber' AND FAEID = eid";
                            $query = mysqli_query($con, $attendant_query);
                            //$result = mysqli_fetch_assoc($query);
                            //$attendant = $result['FAEID'];
                            //echo $attendant;
                           /* $queryAttendant = "SELECT Name FROM employee WHERE eid = '$attendant'";
                            $queryAttendant2 = mysqli_query($con, $queryAttendant);
                            */
                            while($resultAttendant = mysqli_fetch_array($query))
                            {
                            $attendantName = $resultAttendant['Name'];
                        
                            echo $attendantName;
                            echo "<br>";
                            }
                            
                    
                        ?>
                        </div></li>
                        
                        
                
           
           <!--<br>--> 
           <li class="full"><h1 id ="Text">Customers</h1>
                    <div class="list">
                        <?php
                        $flightNumber = $_SESSION['FlightNumber']; //flightNumber = filter_input(INPUT_POST, 'FlightNumber')
                       
                        $query1 = "SELECT Name FROM travels_on, customer WHERE email = CustomerEmail AND FlightNum = '$flightNumber'";
                        $query = mysqli_query($con, $query1);
                       
                        
                        while($result = mysqli_fetch_array($query))
                        {
                            $Ans2 = $result['Name'];
                        
                            echo $Ans2;
                            echo "<br>";
                        }
                       
                        
                        
                        
                        
                        //only displaying one customer though, fix it!
                        
                        ?></div><br><br></li><br></ul><br>
           <form method="POST" action="StationAttendant.php">
                         <br>
                         <input class="button" type="submit" name="BackToStation" value="Back"/> <br><br>
                     </form>
                     
                        <br><br><bR><br><BR></div>
                    
                </div>
           </div>
           
          
           
           
       </div>
       

<?php
//session_unset();
?>
   </body>
</html>

