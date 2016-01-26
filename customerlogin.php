<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<!--<div class ="content">
 <div class="container">-->
<?php
session_start();
    //connect to the database
    $con = mysqli_connect("localhost","root","","basaairline") or die("Some error occured during connection " . mysqli_error($con));
    
    
    //for SIGN IN bxutton
   if(isset($_POST['SubmitIn'])){
       
       $emailSignIn = filter_input(INPUT_POST, 'Email'); //Read username & password into variable 
       $passwordSignIn = filter_input(INPUT_POST, 'Password');
      
        // SELECT the customers w/ that email and that password from the customer table (should just be one)
        $strSQLEmail = "SELECT Email FROM customer WHERE Email='$emailSignIn' AND Password='$passwordSignIn' ";
        $queryEmail = mysqli_query($con, $strSQLEmail);  //submit query to the db
        $resultEmail = mysqli_fetch_array($queryEmail); //should contain a single row w/ the current email (if it exists)
         
        if($resultEmail != NULL) // user exists --> Proceed to sign in
        {
            $_SESSION['userEmail']  = $resultEmail['Email']; //save user's email in Session array
           header("Location: customerHome.php"); // proceed to current tickets page
           exit;
        }
        else{
            //if password and email don't match display error
            echo ' <script type="text/javascript"> alert("Invalid username or password! Please try again."); </script>';
        }
 
   }
   
   //for SIGN UP button
   if(isset($_POST['SubmitUp'])){
       $emailSignUp = filter_input(INPUT_POST, 'Email'); //Read username, password, name and birthdate into variable
       $FName = filter_input(INPUT_POST, 'FName');
       $LName = filter_input(INPUT_POST, 'LName');
       $passwordSignUp = filter_input(INPUT_POST, 'Password');
       $bdateSignUp = filter_input(INPUT_POST, 'Birthdate');
       
       //check to see that the email is not already in the database
       //if not --> add to database and redirect to AccountInfo
       //if the email is not in the database --> 
       $strSQLEmail = "SELECT Email FROM customer WHERE Email='$emailSignUp'";
       $queryEmail = mysqli_query($con, $strSQLEmail);
       $resultEmail = mysqli_fetch_array($queryEmail); //result of the query
       
       //if not a pre-existing e-mail
       if($resultEmail == NULL)
       {
           $fullName = $FName . ' ' . $LName; //combine first/last names into a string
           $querySignUp = "INSERT INTO customer VALUES ('$emailSignUp', '$passwordSignUp', '$fullName', '$bdateSignUp', NULL)";
           $resultSignUp = mysqli_query($con, $querySignUp); //insert new customer into table
           
           //Did the query fail? (db error, not user error if it does)
           if (!$resultSignUp) {
             
             trigger_error("User could not be created!", E_USER_ERROR); //SHOULD NOT HAPPEN
           }
           else{
               $_SESSION['userEmail']  = $emailSignUp; //save user's email in Session array
               header("Location: customerHome.php"); //redirect to Account info page
               exit;
           }
       }
       //if e-mail already exists
       else{
           echo ' <script type="text/javascript"> alert("User could not be created! That e-mail is already in use."); </script>';
       }
       

      
    //sample code for syntax reference

// $strSQL = "SELECT * FROM customer";
// $query = mysqli_query($con, $strSQL);
//  echo '<br>';
//  echo '<br>';
//  while($result = mysqli_fetch_array($query)) {
//  echo $result['Name'] . " " . $result['Birthdate']. " " . $result['Email'] . " " . $result['Password'] . " " . $result['Passport'] . " <br/>";
// }
}
    
?>
<!-- </div></div>-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>BASA Airline</title>
        <link rel="stylesheet" type="text/css" href="style_customer.css" /> 
    </head>
   <body>
       <div class="header">
            <div class="container">
                <a href="index.php"><div class="logo">
                    <img src="airplane.png"/>
                </div>
                <div class="name">
                    <center><h1>BASA Airline</h1></center>	
                    
                </div></a>
                <div class="login"> 
                    <p><a href="customerlogin.php"> Customer Log In </a>| <a href="employeelogin.php">Employee Log In </a></p>
                    </div>
                <div class="menu">
                    <div class="container">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="aboutus.php">About Us</a></li>
                        <li><a href="contactus.php">Contact Us</a></li>
                    </ul>
                    </div>
                </div>
            </div>
       </div>
       
       
       
       
       <div class ="content">
           <div class="container">
              
               <!--MY CODE STARTS HERE -->
               
               <div class="left">
                   <div class="signInOrUp">
                       <h1 ID="boldcenter">Log In</h1> <br><br>
                       
                       <div ID="signInContents">
                           
                           <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                       <form method="POST" action="#">
                           <p ID="userpass"> Email </p> <input ID="inputblock" value ="
                               <?php 
                               if(isset($_POST['SubmitIn'])){echo $emailSignIn;}
                               ?>" type="email" name="Email" required/> <br> <br>
                           
                           <p ID="userpass"> Password </p><input ID="inputblock" type="password" name="Password" required /> <br><br>
                           <br>
                           
                          <input class="signButton" type ="submit" name ="SubmitIn" value ="Log In"/>
                       </form> 
                      </div>
                      
                         
                   </div>
               </div>
               
               
               <div class="right">
                   <div class="signInOrUp">
                       <h1 ID="boldcenter">Sign Up</h1>
                       
                       <div ID="signUpContents">
                           
                           <!-- TODO Change so  I check Username does not exist in database already-->
                           <form method="POST" action="#">
                           <p ID="userpass"> Email </p> <input ID="inputblock" type="email" name="Email" required/> <br><br>
                           <p ID="userpass"> First Name </p> <input ID="inputblock" type="text" name="FName" required/> <br><br>
                           <p ID="userpass"> Last Name </p> <input ID="inputblock" type="text" name="LName" required/> <br><br>
                           <p ID="userpass"> Password </p><input ID="inputblock" type="password" name="Password" required /> <br><br>
                           <p ID="userpass"> Birthdate </p><input ID="inputblock" type="date" name="Birthdate"  required/><br>
                           <br><br>
                           
                           <!--The new input button-->
                           <input class="signButton" type ="submit" name ="SubmitUp" value ="Sign Up"/> 
                       </form> 
                           
                       </div>
                          
                   </div>
               </div>
               
               
               
               
               
               
         
           </div>
           
           
       </div>
	
    </body> 
</html>
