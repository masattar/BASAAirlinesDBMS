<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//connect to the database
    $con = mysqli_connect("localhost","root","","basaairline") or die("Some error occured during connection " . mysqli_error($con));
     
if (isset($_POST['SubmitOut'])) //if user presses the SIGN OUT button
{
    session_destroy(); //end session
    header("Location: index.php"); //redirect to Home page
    exit;
}
    if(isset($_POST['addPlane'])){
        $registrationNum = filter_input(INPUT_POST, 'RegNum'); //Read username & password into variable 
        $Capacity = filter_input(INPUT_POST, 'Cap'); //Read username & password into variable 
        $Model = filter_input(INPUT_POST, 'Mod'); //Read username & password into variable
        
        $strSQLInsert = "INSERT INTO airplane VALUES ('$registrationNum', '$Capacity', '$Model')";
        $queryInsert = mysqli_query($con, $strSQLInsert);
//      if (!$check1_res) {
//          printf("Error: %s\n", mysqli_error($con));
//          exit();
//      }                          
        header("Location:viewplanes.php");
        exit;
    }
                       
    if(isset($_POST['delPlane'])){
        $registrationNum = filter_input(INPUT_POST, 'RegNum'); //Read username & password into variable 
                                               
        $strSQLDelete =  "DELETE FROM airplane WHERE airplane . RegistrationNumber = '$registrationNum'";
        $queryDelete = mysqli_query($con, $strSQLDelete);
//      if (!$check1_res) {
//          printf("Error: %s\n", mysqli_error($con));
//          exit();
//      }                          
        header("Location:viewplanes.php");
        exit;
    }                       
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>BASA Airline</title>
        <link rel="stylesheet" type="text/css" href="style_manager_plane.css" /> 
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
                        <li><a href="viewflights.php">Flights</a></li>
                        <li><div class="currentLink">Airplanes</div></li>
                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class ="content">
            <div class="container">
                <div class="box">
                <h1><center>Airplanes</center></h1>
                <center>
                    <div class="tableHeader">
                        <ul class="headers">
                            <li class="column">Registration#</li>  
                            <li class="column">Capacity</li> 
                            <li class="column">Model</li> 
                        </ul>
                    </div>
                </center>
<!--                <h1 id=boldcenter>View Planes</h1>
                <br>
                <center><div class="tableHeader">
                <ul class><li class="column">Registration Number</li>
                    <li class="column">Capacity</li>  
                    <li class="column">Model</li>
                </ul><br></div></center>-->
           
                <div class="planeList">
                    <?php
                    $strSQL = "SELECT * "
                    . "FROM airplane ";
                    $queryPlane = mysqli_query($con, $strSQL);
                    while($resultPlane = mysqli_fetch_array($queryPlane)){
                        echo "<div class = \"tuple\">"; 
                        echo "<li class=\"tuplecolumn\">". $resultPlane['RegistrationNumber'] . "</li> ";
                        echo "<li class=\"tuplecolumn\">". $resultPlane['Capacity']. "</li> " ;
                        echo "<li class=\"tuplecolumn\">". $resultPlane['Model']. " </li><br/>";
                        echo "</div>";                  
                    }
                    ?>
                </div>

                    <h2>Add Plane</h2> 
                    
                    
                        <ul class="planeAttributes">
                        <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                        <form method="POST" action="#">
                            <li class="label"> Registration Number  <br> <input ID="inputblock" type="text" name="RegNum" required maxlength="6"/> </li>
                            <li class="label"> Capacity  <br> <input ID="inputblock" type="text" name="Cap" required maxlength="3"/> </li>
                            <li class="label"> Model  <br> <input ID="inputblock" type="text" name="Mod" required maxlength="20"/> </li>
                            
                            <li class="label"><br><input class="signButton" type="submit" name="addPlane" value="Add"/> </li>
                        </form> </ul>
                    
    
                    <?php
           
                    ?>
                
                    <br><br><div>
                    <h2>Remove Plane</h2> 
                    <ul class="planeAttributes">
                   
                        
                        <!--FOR NOW: Sign In links to the CurrentTickets Page (gotta learn how to make navigation to the page conditional-->
                        <form method="POST" action="#">
                            <li class="label"> Registration Number  <br> <input ID="inputblock" type="text" name="RegNum" required maxlength="6"/> </li>
                            
                            
                            <li class="label"><br><input class="signButton" type="submit" name="delPlane" value="Delete"></li>
                        </form> </div>
                </div></div></div>
 
     
                    
                    <?php
                    
                    ?>
                
 
        
    
    </body> 
</html>
