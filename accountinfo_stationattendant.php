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
$empID =  $_SESSION['empID'];

//select all the customer's attributes from the db
$strSQL = "SELECT * FROM employee WHERE eid='$empID'";
$queryEmp = mysqli_query($con, $strSQL);  //submit query to the db
$resultEmp = mysqli_fetch_array($queryEmp); //should contain a single row w/ all the customer's attributes

//read in the customer's info
//$emID = $resultEmp['eid'];
$empName = $resultEmp['Name'];
$empSex = $resultEmp['Sex'];
$empBdate = $resultEmp['Birthdate'];
$empSalary = $resultEmp['Salary'];
$empPass = $resultEmp['Password'];

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
                <a href="StationAttendant.php">
                    <div class="logo">
                        <img src="airplane.png"/>
                    </div>
                    <div class="name">
                        <center><h1>BASA Airline</h1></center>	
                    </div>
                </a>
                <div class="login"> 
                    <p><b>My Account</b> | <a href="index.php"> Sign Out </a>
                </div>
                <div class="menu">
                    <div class="container">
                    <ul>
                        <li><a href="StationAttendant.php">Home</a></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class ="content">
           <div class="container">
               <div class="box"><br>
                   <h1> <center>Account Information </center></h1>
                   
                   <ul>
                       <li class="accProp"><p class="cusAttrLeft"> Employee ID: </p><p class="cusAttrRight"><?php echo $empID;?></p></li>
                       <li class="accProp"><p class="cusAttrLeft"> Name: </p><p class="cusAttrRight"><?php echo $empName;?></p></li>
                       <li class="accProp"><p class="cusAttrLeft"> Sex: </p><p class="cusAttrRight"><?php echo $empSex;?></p></li>
                       <li class="accProp"><p class="cusAttrLeft"> Birthdate: </p><p class="cusAttrRight"><?php echo date('F jS, Y', strtotime($empBdate)); ?></p></li>
                       <li class="accProp"><p class="cusAttrLeft"> Salary: </p><p class="cusAttrRight"><?php echo $empSalary;?></p></li>
                       <div class="button"><a href="editEmployeeAccountInfoSA.php">Edit </a></div>
                   </ul>
                   
               </div>
 
           </div>
           
           
       </div>
	
    </body> 
</html>
