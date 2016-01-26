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



if(isset($_POST['save'])){
    $nameChange = filter_input(INPUT_POST, 'cusNewName'); //Read username, password, name and birthdate into variable
    $emailChange = filter_input(INPUT_POST, 'cusNewEmail');
    $passChange = filter_input(INPUT_POST, 'cusNewPass');

     $_SESSION['userEmail'] = $emailChange; 
    $strSQL = "UPDATE customer SET Name='$nameChange', Email = '$emailChange', Password='$passChange' WHERE Email='$cusEmail'";
    $queryEmp = mysqli_query($con, $strSQL);  //submit query to the db
    $resultEmp = mysqli_fetch_array($queryEmp); //should contain a single row w/ all the customer's attributes

    header("Location: customerAccountInfo.php"); //redirect to Home page
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
                       <li><a href="customerAccountInfo.php"><b>My Account</b></a></li>
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
               <!--INSERT MY CODE HERE -->
               <div class="box"><br>
                   <div class="backbutton"><a href="customerAccountInfo.php">Back</div></a>
                   <h1 ID="boldcenter"> <br><br>Account Information </h1><br>
               
                   <ul><br><br><br>
                       <form method="POST" action="#">
                           <li class="accProp"><p class="cusAttrLeft"> Name: </p><input ID="inputblock" type="text" name="cusNewName" required maxlength="50"/></li> 
                           <li class="accProp"><p class="cusAttrLeft"> Email: </p><input ID="inputblock" type="email" name="cusNewEmail" required maxlength="50"/></li>
                           <li class="accProp"><p class="cusAttrLeft"> Birthdate: </p><p class="cusAttrRight"><?php echo date('F jS, Y', strtotime($cusBdate)); ?></p></li>
                           <li class="accProp"><p class="cusAttrLeft"> Password: </p><input ID="inputblock" type="password" name="cusNewPass" required maxlength="50"/> <br>
                           
                           <input class="button" type="submit" name="save" value="Save"/> 
                       </form>
                       
                       
                       
                   </ul></div>
               </div>
               
           </div>
           
               
               
               
               
               
               
               
               
           </div>
           
           
       </div>
	
    </body> 
</html>
