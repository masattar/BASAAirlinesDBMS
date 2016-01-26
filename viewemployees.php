<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//connect to the database
$con = mysqli_connect("localhost", "root", "", "basaairline") or die("Some error occured during connection " . mysqli_error($con));

session_start();
  $managerID = $_SESSION['empID'];
if (isset($_POST['SubmitOut'])) //if user presses the SIGN OUT button
{
    session_destroy(); //end session
    header("Location: index.php"); //redirect to Home page
    exit;
}
?>
<?php
if (isset($_POST['AddEmployee'])) {
    $Name = filter_input(INPUT_POST, 'EmpNameBox');
    $ID = rand(10000000,99999999);
    
    $idunique = true; //assume the ticket is initially unique
                       
                       
                       while(true) //while true loop
                       {
                           $strSQLidNum = "SELECT eid "
                               . "FROM employee ";
                           
                           $queryIDNum = mysqli_query($con, $strSQLidNum); 
                           
                           while($resultTicketNum = mysqli_fetch_array($queryIDNum)) //go through all the ticket numbers that exist in the db
                           {
                               if($resultTicketNum['eid'] == $ID){ //if at any point that ticket number already exists
                                   $idunique = false; //signal that the ticket already exists
                                   $ticketNum = rand(10000, 99999); //generate new random 5-digit number (to try again)
                                   break; //found a match so break out of the loop 
                               }
                           }
                           
                           if($idunique) // if the ticket is still unique at this point it's good 2 go
                           {
                               break; //break out of the true loop
                           }
                           //otherwise start the loop all over again
                       }
    
    
    
    $Sex = filter_input(INPUT_POST, 'SexSelect');
    $Bdate = filter_input(INPUT_POST, 'EmpBirthdateBox');
    $Salary = filter_input(INPUT_POST, 'EmpSalaryBox');
    $Password = filter_input(INPUT_POST, 'EmpPasswordBox');
    $MGReid = filter_input(INPUT_POST, 'EmpMGRidBox');
    $strSQLInsert = "INSERT INTO `basaairline`.`employee` (`eid`, `Name`, `Sex`, `Birthdate`, `Salary`, `Password`, `MGReid`) VALUES ('$ID', '$Name', '$Sex','$Bdate','$Salary','$Password', '$MGReid')";
    $queryInsert = mysqli_query($con, $strSQLInsert);
    /* if (!$check1_res) {
      printf("Error: %s\n", mysqli_error($con));
      exit();
      } */
    header("Location:viewemployees.php");
}
if (isset($_POST['RemoveEmployee'])) {
   
    

         $ID = filter_input(INPUT_POST, 'EmpIDBoxD');
       
    echo ' <script type="text/javascript"> alert("Cannot remove yourself."); </script>';
             
                   $strSQLDelete = "DELETE FROM `basaairline`.`employee` WHERE eid = '$ID'";
    $queryDelete = mysqli_query($con, $strSQLDelete);
             
    if ($queryDelete == true) {
        header("Location:viewemployees.php");
    }
    else {
        echo ' <script type="text/javascript"> alert("Employee does not exist. Please try again."); </script>';
    }
}
if (isset($_POST['updateEmployee'])) {
    
    $ID = filter_input(INPUT_POST, 'EmpIDBoxE');
    
    $Salary = filter_input(INPUT_POST, 'EmpSalary');
    if ($ID != $managerID) {
        
    $strSQLEdit = "UPDATE employee SET Salary = '$Salary' WHERE eid='$ID'";
    $queryEdit = mysqli_query($con, $strSQLEdit);
    
    if ($queryEdit == true) {
        header("Location:viewemployees.php");
    }
    else {
        echo ' <script type="text/javascript"> alert("Employee does not exist. Please try again."); </script>';
    }}
    else {
        echo ' <script type="text/javascript"> alert("Cannot update your own salary."); </script>';
    }
}

if (isset($_POST['AddPilot'])) {
    $ID = filter_input(INPUT_POST, 'PilotIDBox');
    $License = filter_input(INPUT_POST, 'PilotLicenseBox');
    $pilotInsert = "INSERT INTO pilot VALUES ('$ID','$License')";
    $queryInsert = mysqli_query($con, $pilotInsert);

    if ($queryInsert == false) {
        echo ' <script type="text/javascript"> alert("Employee does not exist. Please try again."); </script>';
    }
    else {
        header("Location:viewemployees.php");
    }
}
if (isset($_POST['RemovePilot'])) {
    $ID = filter_input(INPUT_POST, 'PilotIDBoxD');
    $pilotDelete = "DELETE FROM pilot WHERE PilotEID = '$ID'";
    $queryDelete = mysqli_query($con, $pilotDelete);
    header("Location:viewemployees.php");
}

if (isset($_POST['AddFA'])) {
    $ID = filter_input(INPUT_POST, 'faIDBox');
    $Class = filter_input(INPUT_POST, 'faClassBox');
    $faInsert = "INSERT INTO flight_attendant VALUES ('$ID','$Class')";
    $queryInsert = mysqli_query($con, $faInsert);
    if ($queryInsert == false) {
        echo ' <script type="text/javascript"> alert("Employee does not exist. Please try again."); </script>';
    }
    else {
        header("Location:viewemployees.php");
    }
}

if (isset($_POST['AddFAF'])) {
    $ID = filter_input(INPUT_POST, 'faIDBoxF');    
    $Class = filter_input(INPUT_POST, 'faClassBoxF');
    $faInsert = "INSERT INTO works_in VALUES ('$Class','$ID')";
    $queryInsert = mysqli_query($con, $faInsert);
    if ($queryInsert == false) {
        echo ' <script type="text/javascript"> alert("Employee or flight does not exist. Please try again."); </script>';
    }
    else {
        header("Location:viewemployees.php");
    }
}
if (isset($_POST['RemoveFA'])) {
    $ID = filter_input(INPUT_POST, 'faIDBoxD');
    $faDelete = "DELETE FROM flight_attendant WHERE FlightAttendantEID = '$ID'";
    $queryDelete = mysqli_query($con, $faDelete);
    header("Location:viewemployees.php");
}

if (isset($_POST['AddSA'])) {
    $ID = filter_input(INPUT_POST, 'saIDBox');
    $Airport = filter_input(INPUT_POST, 'saAirportBox');
    $StationNumber = filter_input(INPUT_POST, 'saStaionNumberBox');
    $saInsert = "INSERT INTO station_attendant VALUES ('$ID','$StationNumber', '$Airport')";
    $queryInsert = mysqli_query($con, $saInsert);
    if ($queryInsert == false) {
        echo ' <script type="text/javascript"> alert("Employee and/or airport does not exist. Please try again."); </script>';
    }
    else {
        header("Location:viewemployees.php");
    }
}
if (isset($_POST['RemoveSA'])) {
    $ID = filter_input(INPUT_POST, 'saIDBoxD');
    $saDelete = "DELETE FROM station_attendant WHERE StationAttendantEID = '$ID'";
    $queryDelete = mysqli_query($con, $saDelete);
    header("Location:viewemployees.php");
}
?> 
<html>
    <head>
        <meta charset="UTF-8">
        <title>BASA Airline</title>
        <link rel="stylesheet" type="text/css" href="style_manager2.css" /> 
    </head>
    <body>
        <div class="header">
            <div class="container">
                <a href="managerhome.php"><div class="logo">
                        <img src="airplane.png"/>
                    </div>
                    <div class="name">
                        <center><h1>BASA Airline</h1></center>	

                    </div></a>
                <div class="login"> 
                     <p><a href="accountinfo.php">My Account</a> | <a href="index.php"> Sign Out </a>
                </div>
                <div class="menu">
                    <div class="container">
                        <ul>
                            <li><a href="managerhome.php">Home</a></li>
                            <li><div class="currentLink">Employees</div></li>
                            <li><a href="viewflights.php">Flights</a></li>
                            <li><a href="viewplanes.php">Airplanes</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

       
            <div class="container2"> <div class ="content">
                
                    <div class="box"><br>
                        <center><b>View</b> | <a href="searchemployees.php">Search</a> 
                </center>
                <h1><center>Employees</h1></center>
                <center><div class="tableHeader">
                        <ul class="headers"><li class="column">Name</li>
                            <li class="column">ID</li>  
                            <li class="column">Birthdate</li> 
                            <li class="column">Salary</li>  
                            <li class="column">Sex</li> 
                        </ul></div></center>
                <div class ="employeeList">
<?php
$strSQL = "SELECT * FROM employee WHERE MGReid = $managerID ORDER BY Name";
$query = mysqli_query($con, $strSQL);/*
if (!$check1_res) {
   printf("Error: %s\n", mysqli_error($con));
    exit();
}*/
while ($result = mysqli_fetch_array($query)) {
    if ($result['eid']!=$managerID) {
    echo "<div class = \"tuple\">";
    echo "<li class=\"tuplecolumn\">" . $result['Name'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['eid'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['Birthdate'];
    echo "<li class=\"tuplecolumn\">" . " $" . $result['Salary'];
    echo "<li class=\"tuplecolumn\">" . $result['Sex'] . " ";

    echo " <br/>";
    echo "</div>";
    echo "<br>";}
}
?>
                </div><br>
                <div class="alter">
                    <h2>Add Employee</h2>
                <div class = "addremove"> <ul class ="employeeAttributes"><form method ="POST" >  
                        

    <li class="label"> Full Name <br><input ID="inputblock" type="text" name="EmpNameBox" maxlength="50" required/></li>
    
    <li class="label"> Sex <br><select name ="SexSelect">
                            <option value=""></option>
                            <option value="F">Female</option>
                            <option value="M">Male</option>
                            </select></li>
                          
                            <li class="label"> Birthdate<br><input ID="inputblock" type="date" name="EmpBirthdateBox" maxlength="10" required/></li>
                            <li class="label"> Salary<br><input ID="inputblock" type="text" name="EmpSalaryBox" maxlength="7" required/></li>
                            <li class="label"> Password<br><input ID="inputblock" type="password" name="EmpPasswordBox" maxlength="50" required/></li>
                            <li class="label">  Manager ID<br><input ID="inputblock" type="text" name="EmpMGRidBox" maxlength="8" required/></li>
                            <li class="label"> <br><input class="button" type="submit" name="AddEmployee" value="Add"/>  </li>


                    </form></ul>
</div><br><br><br><br><br>
                    <br><br>
                <h2>Remove Employee</h2>
                <div class="addremove">
                    <ul class="employeeAttributes">
                    <form method ="POST" >  
                        <li class="label">ID <br> <input ID="inputblock" type="text" name="EmpIDBoxD" maxlength="8" required/></li>
                        <li class="label"><br><input class="button" type="submit" name="RemoveEmployee" value="Remove"/> </li>
                    </form> </div><br><br><br>
                </div>
                <h2>Edit Employee Salary</h2>
                <div class="addremove">
                    <ul class="employeeAttributes">
                    <form method ="POST" >  
                        <li class="label">ID <br> <input ID="inputblock" type="text" name="EmpIDBoxE" maxlength="8" required/></li>
                        <li class="label">Salary <br> <input ID="inputblock" type="text" name="EmpSalary" maxlength="8" required/></li>
                        <li class="label"><br><input class="button" type="submit" name="updateEmployee" value="Update"/> </li>
                    </form> </div><br><br><br>
                </div>
                
                    </div>
                    <div class="box">
                    <h1><center>Pilots</center></h1>
                <center><div class="tableHeader">
                        <ul class="headers"><li class="column">Name</li>
                            <li class="column">ID</li>  
                            <li class="column"> License #</li>
                        </ul></div></center>

                <div class ="smallEmployeeList">
<?php
$strSQL = "SELECT * FROM employee, pilot WHERE eid = PilotEID ORDER BY Name";
$query = mysqli_query($con, $strSQL);

while ($result = mysqli_fetch_array($query)) {
    echo "<div class = \"tuple\">";
    echo "<li class=\"tuplecolumn\">" . $result['Name'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['eid'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['LicenseNumber'] . " ";

    echo "</div>";
    echo "<br>";
}
?>
                </div>
                    <h2>Add Pilot</h2>
<div class="addremove">
                <form method ="POST" > 
                    <ul class="employeeAttributes">
                        <li class="label">Employee ID <br><input ID="inputblock" type="text" name="PilotIDBox" maxlength = "8" required /></li>
                    <li class="label">License Number <br><input ID="inputblock" type="text" name="PilotLicenseBox" maxlength="12" required /></li>

                    <li class="label"><br><input class="button" type="submit" name="AddPilot" value="Add"/> </li>
                    
                    </ul>
                </form>
</div><br><br><br>

                    <div class="addremove">
                    <h2>Remove Pilot</h2><ul class="employeeAttributes">
                <form method ="POST">
                    <li class="label">Employee ID<br> <input ID="inputblock" type="text" name="PilotIDBoxD" maxlength = "8" required /></li>
                    <li class="label"><br><input class="button" type="submit" name="RemovePilot" value="Remove"/> </li>
                    </ul> </form> </div><br><br><br></div><div class="box">
                    <h1><center>Flight Attendants</center></h1>

                <center><div class="tableHeader">
                        <ul class="headers"><li class="column">Name</li>
                            <li class="column">ID</li>  
                            <li class="column">Class</li> 
                        </ul></div></center>
                <div class ="smallEmployeeList">
<?php
$strSQL = "SELECT * FROM employee, flight_attendant WHERE eid = FlightAttendantEID ORDER BY Name";
$query = mysqli_query($con, $strSQL);

while ($result = mysqli_fetch_array($query)) {
    echo "<div class = \"tuple\">";
    echo "<li class=\"tuplecolumn\">" . $result['Name'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['eid'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['Class'] . " ";

    echo "</div>";
    echo "<br>";
}
?>
                </div><br>
                <div class="addremove">
                    <h2>Add Flight Attendant</h2>
                <form method ="POST" >  <ul class="employeeAttributes">
                        <li class="label">Employee ID <br><input ID="inputblock" type="text" name="faIDBox" maxlength="8" required /></li>
                        <li class="label">Class <br><input ID="inputblock" type="text" name="faClassBox" maxlength="20" required /></li>
                        <li class="label"><br><input class="button" type="submit" name="AddFA" value="Add"/> </li>
                   
                    </ul></form><br><br><br>
                    <h2>Remove Flight Attendant</h2>
                <form method="POST"><ul class="employeeAttributes">
                        <li class="label">Employee ID <br><input ID="inputblock" type="text" name="faIDBoxD" maxlength="8" required /></li>
                        <li class="label"><br><input class="button" type="submit" name="RemoveFA" value="Remove"/> </li>
                </ul></form> </div>
                <br><BR><BR> <h2>Add Flight Attendant to Flight</h2>
                <form method ="POST" >  <ul class="employeeAttributes">
                        <li class="label">Employee ID <br><input ID="inputblock" type="text" name="faIDBoxF" maxlength="8" required /></li>
                        <li class="label">Flight Number <br><input ID="inputblock" type="text" name="faClassBoxF" maxlength="6" required /></li>
                        <li class="label"><br><input class="button" type="submit" name="AddFAF" value="Add"/> </li>
                   
                    </ul></form><br><br><br>
                
                </div><div class="box">
                <h1> <CENTER>Station Attendants </center></h1>
                
                <center><div class="tableHeader">
                        <ul class="headers"><li class="column">Name</li>
                            <li class="column">eid</li>  
                            <li class="column">Airport Code</li> 
                            <li class="column">Station #</li> 
                        </ul></div></center>
                <div class ="smallEmployeeList">
<?php
$strSQL = "SELECT * FROM employee, station_attendant WHERE eid =StationAttendantEID";
$query = mysqli_query($con, $strSQL);

while ($result = mysqli_fetch_array($query)) {
    echo "<div class = \"tuple\">";
    echo "<li class=\"tuplecolumn\">" . $result['Name'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['eid'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['ACode'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['StationNumber'];
    echo "</div>";
    echo "<br>";
}
?>
                    
                   

                </div>
                <h2>Add Station Attendant</h2>
                <ul class="employeeAttributes">
                 <form method ="POST" >  
                     <li class="label">Employee ID <br><input ID="inputblock" type="text" name="saIDBox" maxlength="8" required /></li>
                    <li class="label">Airport Code<br><input ID="inputblock" type="text" name="saAirportBox" maxlength="3" required /></li>
                    <li class="label">Station Number<br> <input ID="inputblock" type="text" name="saStaionNumberBox" maxlength="2" required /></li>
                    <li class="label"><br><input class="button" type="submit" name="AddSA" value="Add"/> </li>
                 </form></ul><br>
<h2>Remove Station Attendant</h2>
                <ul class="employeeAttributes">
                <form method="POST"> 
                    <li class="label">Employee ID<br> <input ID="inputblock" type="text" name="saIDBoxD" maxlength="8" required /></li>
                    <li class="label"><br><input class="button" type="submit" name="RemoveSA" value="Remove"/> </li>
                </form> </ul><br>

                <br><br>
                </div>
        </div>



    </body> 
</html>
