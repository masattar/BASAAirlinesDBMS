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
                   <div class="signInOrUp">
                       <h1 ID="boldcenter"><br>Log In</h1> 
                       
                       <div ID="signInContents">
                           
                           <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                           <form method="POST" action="#">
                               <p ID="userpass"> Employee ID </p> <input ID="inputblock" type="text" name="EmpID" required maxlength="8"/> <br> <br>
                           <p ID="userpass"> Password </p><input ID="inputblock" type="password" name="Password" required /> <br><br>
                           <br>
                           
                          <input class="signButton" type="submit" name="SignIn" value="Log In"/> 
                      </div>
                       </form> 
                           <?php 
                           if(isset($_POST['SignIn'])){
                               //Stuff here for sign in
                               $IDSignIn = filter_input(INPUT_POST, 'EmpID'); //Read username & password into variable 
                               $passwordSignIn = filter_input(INPUT_POST, 'Password');
                           
                               //printf($IDSignIn);
                               //printf($passwordSignIn);
                               
//                               header("Location:nxtpage.php");
                               //checking to see if username and password exists or not
                               $query_ID = "SELECT eid FROM employee WHERE eid = '$IDSignIn' AND Password = '$passwordSignIn'";
                               $query = mysqli_query($con, $query_ID);
                               $result = mysqli_fetch_array($query);//contains one row of the table with right eid
                               // *********************
                               if($result != NULL) // user exists --> Proceed to sign in
                                {
                                    $_SESSION['empID']  = $result['eid']; //save user's email in Session array
                                }
                                else{
                                    //if password and email don't match display error
                                    echo ' <script type="text/javascript"> alert("Invalid username or password! Please try again."); </script>';
                                }
                               
//                               $query_mgr = "SELECT eid FROM employee WHERE eid = MGReid";
//                               $query_two = mysqli_query($con, $query_mgr);
//                               $result_two = mysqli_fetch_array($query_two);
                               //manager's stuff
                               $query_MgrID = "SELECT eid, Name FROM employee as E1 WHERE E1.eid IN "
                                       . "(SELECT MGReid FROM employee as E2)";
                               
                               $query_Mgr= mysqli_query($con, $query_MgrID);
                                $mgr_array = mysqli_fetch_all($query_Mgr, MYSQLI_ASSOC);
                                $login_success = false;
                                foreach ($mgr_array as $manager){
//                                    echo $manager['Name']." ".$IDSignIn;
                                    if($manager['eid'] == $IDSignIn){
                                        $login_success = true;
                                        break;
                                    }
                                   // echo "\n";
                                }
                               // echo $login_success;
                               //$result_Mgr = mysqli_fetch_array($query_Mgr);
                              
//                               $query_managers = "SELECT eid FROM EMPLOYEE WHERE EMPLOYEE.eid in $query_MgrID";
//                               
//                               $resultCheck= "SELECT * FROM $query_ID WHERE $query_ID.eid in $query_managers";
//                               
//                               if ($resultCheck != NULL)
//                               {
//                                   echo "manager";
//                               }
//                               else
//                               {
//                                   echo "employee";
//                               }
                               
//                               $query_MgrID = "SELECT MGReid FROM employee";
//                               $query_managers = "SELECT eid FROM EMPLOYEE WHERE EMPLOYEE.eid in $query_MgrID";
//                               "SELECT * FROM $query_ID WHERE $query_ID.eid in $query_managers";
//                               
//                               $query_Mgr = mysqli_query($con, $query_managers);
//                               $result_Mgr = mysqli_fetch_array($query_Mgr);
////                               
//                               if ($result_Mgr != NULL)
//                               {
//                                   
//                                   echo "Manager";
//                                   //header("Location:StationAttendant.php");
//                               }
//                               else if ($result != NULL)
//                               {
//                                   echo "Employee";
//                               }
//                               else
//                               {
//                                   echo "invalid";
//                               }//FIX LATER!! MANAGERID
//                               
                               if ($result != NULL)
                               {
                                   
                                   //echo ' <script type="text/javascript"> alert("It works!."); </script>';
                                   if ($login_success)
                                    {
                                            //GO TO MANAGER
                                            header("Location:managerhome.php");
                                            exit;
                                            //echo "Manager";
                                    }
                                    else
                                    {
                                            header("Location:StationAttendant.php");
                                            exit;
                                            //echo"emp";
                                    }
                               }
                               else
                               {
                                   echo ' <script type="text/javascript"> alert("Invalid username or password! Please try again."); </script>';
                               }
//                               
                               
                               
                               
                              // header("Location:StationAttendant.php");
//                               $_POST['SignIn'] = 'employeelogin.php';
                               //unset($_POST['SignIn']);
                               
                           }
                            
                             //unset($_POST['SignIn']);
//                           $IDSignIn = filter_input(INPUT_POST, 'EmpID'); //Read username & password into variable 
//                           $passwordSignIn = filter_input(INPUT_POST, 'Password');
//                           echo $IDSignIn;
//                           echo$passwordSignIn;
//                           //header("Location:StationAttendant.php");
//                           
//                            echo $username;
//                            echo $password;
                           // check whether username and password are valid (also that they're not empty)
                           // SELECT the eid w/ that email from the customer table
                           // SELECT all eids w/ that password from the cutomer table
                           // Check that the username eid is in the password eid table
                           // If result is NOT NULL then --> PASSES --> go to next page
                           // Otherwise (username eid is not in password table) --> FAILS --> display error message
                           // DO IT W/ FOLLOWING CODE
                           // if(/* Your conditions */){
                            // redirect if fulfilled
                            // header("Location:nxtpage.php");
                           // }
                           // else{
                                //some another operation you want
                           // }
                           
                           ?>
                   </div>
               </div>            
             
           
           
       </div>
		
        <?php
        
        ?>
    </body> 
</html>
