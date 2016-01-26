<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
//connect to the database
$con = mysqli_connect("localhost", "root", "", "basaairline") or die("Some error occured during connection " . mysqli_error($con));
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
                            <li><b>Employees</b></li>
                            <li><a href="viewflights.php">Flights</a></li>
                            <li><a href="viewplanes.php">Airplanes</a></li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class ="content">
            <div class="container">
                <div class="box"><br>
                <center><a href="viewemployees.php">View</a> | <b>Search</b> 
                </center>            <br>
                
                <h1><center>Search Employee</center></h1>
                <div class = "searchInput1"> <form method ="POST" >  
                        Name <input ID="inputblock" type="text" name="searchEmpNameBox" maxlength="50"/>
                        <input class="button" type="submit" name="SearchName" value="Search"/> 
                    </form></div>
                <div class ="searchInput2">
                    <form method ="POST" >  
                        Employee ID <input ID="inputblock" type="text" name="searchEmpIDBox" required maxlength="8"/>
                        <input class="button" type="submit" name="SearchEID" value="Search"/> </form>
                </div><br>
                <br>

                <?php
                $result['Name'] = '';
                $ename = '';
                $eid = '';
                if (isset($_POST['SearchName'])) {

                    $ename = filter_input(INPUT_POST, 'searchEmpNameBox'); //Read username & password into variable 

                    $searchedNameQuery = "SELECT * FROM employee WHERE Name LIKE '%$ename%'";
                    $querySearchEmployeeName = mysqli_query($con, $searchedNameQuery);
                    $result = mysqli_fetch_array($querySearchEmployeeName);

                    /* if (!$check1_res) {
                      printf("Error: %s\n", mysqli_error($con));
                      exit();
                      } */
                    //header("Location:searchemployees.php");
                } else if (isset($_POST['SearchEID'])) {
                    $eid = filter_input(INPUT_POST, 'searchEmpIDBox'); //Read username & password into variable 

                    $searchedIDQuery = "SELECT * FROM employee WHERE eid LIKE '$eid'";
                    $querySearchEmployeeID = mysqli_query($con, $searchedIDQuery);
                    $result = mysqli_fetch_array($querySearchEmployeeID);
                } else {
                    $result['Name'] = '';
                    $result['eid'] = '';
                    $result['Sex'] = '';
                    $result['Birthdate'] = '';
                    $result['Salary'] = '';
                    $result['Password'] = '';
                    $result['MGReid'] = '';
                }
                ?>

                <center><div class="tableHeader">
                        <ul class="headers"><li class="column"> Name</li>
                            <li class="column">eid</li>  
                            <li class="column">Sex</li> 
                            <li class="column">Birthdate</li> 
                            <li class="column">Salary</li>  
                        </ul></div></center>
                <div class ="smallEmployeeList">
<?php
//echo $result['Name'];
if (!isset($_POST['SearchName']) && !isset($_POST['SearchEID'])) {
    echo "<div class =\"defaultText\"><br><br>" . 'Enter an Employee name or ID above' . "</div>";
} else if ($result == NULL) {
    if (isset($_POST['SearchName']))
        echo "<div class =\"errorText\"><br><br>" . 'Employee with the name "' . $ename . '" does not exist' . "</div>";
    else if (isset($_POST['SearchEID']))
        echo "<div class =\"errorText\"><br><br>" . 'Employee with the ID "' . $eid . '" does not exist' . "</div>";
}

else {
    echo "<div class = \"tuple\">";
    echo "<li class=\"tuplecolumn\">" . $result['Name'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['eid'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['Sex'] . " ";
    echo "<li class=\"tuplecolumn\">" . $result['Birthdate'];
    echo "<li class=\"tuplecolumn\">" . $result['Salary'] . " <br/>";
    echo "</div>";
}
?>

                </div><br>

            </div>
        </div>	

    </body> 
</html>
