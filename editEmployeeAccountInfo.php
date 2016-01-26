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

if (isset($_POST['SubmitOut'])) //if user presses the SIGN OUT button
{
    session_destroy(); //end session
    header("Location: index.php"); //redirect to Home page
    exit;
}

if(isset($_POST['save'])){
    $nameChange = filter_input(INPUT_POST, 'empName'); //Read username, password, name and birthdate into variable
    $sexChange = filter_input(INPUT_POST, 'empSex');
    $passChange = filter_input(INPUT_POST, 'empPass');

    $strSQL = "UPDATE employee SET Name='$nameChange', Sex='$sexChange', Password='$passChange' WHERE eid='$empID'";
    $queryEmp = mysqli_query($con, $strSQL);  //submit query to the db
    $resultEmp = mysqli_fetch_array($queryEmp); //should contain a single row w/ all the customer's attributes

    header("Location: accountinfo.php"); //redirect to Home page
    exit;
}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>BASA Airline</title>
        <link rel="stylesheet" type="text/css" href="style_manager_info.css" /> 
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
                    <p><b><a href="accountinfo.php">My Account</a></b> | <a href="index.php"> Sign Out </a>
                </div>
                <div class="menu">
                    <div class="container">
                    <ul>
                        <li><a href="managerhome.php">Home</a></li>
                        <li><a href="viewemployees.php">Employees</a></li>
                        <li><a href="viewflights.php">Flights</a></li>
                        <li><a href="viewplanes.php">Airplanes</a></li>
                        
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class ="content">
           <div class="container">
               <!--INSERT MY CODE HERE -->
               <div class="box">
                   <br>
                   <div class="backbutton"><a href="accountinfo.php">Back</a></div><br>
                   <h1 ID="boldcenter"> <center>Edit Account Information </center></h1>
             
                   <ul>
                        <form method="POST" action="#">
                            <li class="accProp"><p class="cusAttrLeft"> Employee ID: </p><p class="cusAttrRight"><?php echo $empID;?></p></li>
                            <li class="accProp"><p class="cusAttrLeft"> Name: </p><input ID="inputblock" type="text" name="empName"  required maxlength="50"/></li> 
                            <li class="accProp"><p class="cusAttrLeft"> Sex: </p><p class="cusAttrRight"><?php echo $empSex;?></p></li>
                            <li class="accProp"><p class="cusAttrLeft"> Birthdate: </p><p class="cusAttrRight"><?php echo date('F jS, Y', strtotime($empBdate)); ?></p></li>
                            <li class="accProp"><p class="cusAttrLeft"> Salary: </p><p class="cusAttrRight"><?php echo $empSalary;?></p></li>
                            <li class="accProp"><p class="cusAttrLeft"> Password: </p><input ID="inputblock" type="password" name="empPass" required maxlength="50"/> <br>
                            <br>
                           
                            <input class="button" type="submit" name="save" value="Save"/> 
                        </form> 
                       <br><br><br>
                       
                       <!--<li class="accProp"><p class="cusAttrLeft"> Name: </p><p class="cusAttrRight"><?php echo $empName;?></p></li>-->
                       <!--<li class="accProp"><p class="cusAttrLeft"> Sex: </p><p class="cusAttrRight"><?php echo $empSex;?></p></li>-->
                       
                       <!--<li class="accProp"><p class="cusAttrLeft"> Salary: </p><p class="cusAttrRight"><?php echo $empSalary;?></p></li>-->
                       <!--<li class="accProp"><p class="cusAttrLeft"> Password: </p><p class="cusAttrRight"><?php echo $empPass;?></p></li>-->
                      
                   </ul>
               
 
           </div>
           
           
       </div>
	
    </body> 
</html>
