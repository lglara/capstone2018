<?php
session_start();//continues the session containing prevouse information

if (!isset($_SESSION['username'])) { //if not set, it means that admin hasn't logged in
    header("Location: logIn.php"); //redirects users to login page
    exit;
}
// echo $_SESSION['userId'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="css/layout.css" type="text/css" />
        <link rel="stylesheet" href="css/inventory.css" type="text/css" />
    </head>
    <style>
        .homeNavBtn{
            width: 50%;
            font-size:20px;
            margin:20px;
            color:white;
            background-color:#b9db01;
            border: 1px solid white;
            padding:15px;
            border-radius:15px;
        }
        #homeTitle{
            padding-top:40%;
        }
    </style>
    <body>
        <div id="bodyWrapper">
            <div class="mainDivs" id="nav">
                    <ul id="homeNav">
                        <li><a id="homeBtn" class="navBtn active" href="home.php">Home</a></li>
                    </ul>
                    <ul id="pagesNav">
                      <li><a class="navBtn" href="samplingRequests.php">Sampling Orders</a></li>
                      <li><a class="navBtn" href="collectedSamples.php">Collected Samples</a></li>
                      <li><a class="navBtn" href="sampleReports.php">Sampling Reports</a></li>
                      <li><a class="navBtn" href="admin.php">Admin</a></li>
                      <li><a class="navBtn" href="addSamplingRequest.php">Add Sampling Request</a></li>
                      
                    </ul>
                    <ul id="logOutNav">
                        <li id="logOutBtn"><a class="navBtn" href="logout.php">Log Out</a></li>
                    </ul>
            </div>
            
            <div class="mainDivs" id="collectiveInfo">
                <!--<div id="search">-->
                <!--    <div id="searchInputDiv" class="searchBox1">-->
                <!--        <input id="searchInput" onkeyup="search()" placeholder="Search by Company.." type="text" name="search"/>-->
                <!--    </div>-->
                <!--    <div id="searchBtnDiv" class="searchBox1">-->
                <!--        <button id="searchBtn">|Search</button>-->
                <!--    </div>-->
                <!--</div>-->
                <div id="records">
                    <div id="inventory">
                        <div class="title" id="homeTitle">
                            <Center><div>Welcome <?= $_SESSION[adminFullName]?></div></Center>
                        </div>
                        <div class="table">
                            <table id="currentInventory"></table>
                        </div>
                    </div>
                </div>
                <div id="footer1" class="footer"><center>PRIORITY SAMPLING</center></div>
            </div>
            
            <div class="mainDivs" id="individualInfo">
                <div id="dateTimeInfo">
                    <div class="dateUserInfo" id="logo"><img id="logoImg" src="images/logo.png"></img></div>
                    <div class="dateUserInfo" id="blankSpace"></div>
                    <div class="dateUserInfo" id="dayUserInfo">
                        <div id="currentDate"></div>
                        <div id="currentTime"></div>
                        <div id="userNameLName"><?= $_SESSION[adminFullName]?></div>
                    </div>
                </div>
                
                <div id="recordInfo">
                    <div id="updateRec" title="Dialog Title" class="infoSection popUpBox ">
                            <form class="popup-content animate">
                            <div class="infoSection">PopUp Window!</div>
                                <div id="sampId" style="display:hidden"></div>
                                <!--<div id="collectedSampId" style="display:hidden"></div>-->
                                <!--    <label for="sampSubTime">Sample Submission Time:</label>-->
                                <!--    <input id="sampSubTime" type="time" step="2" name="sampSubTime"/> <br>-->
                                <!--    <label for="woNum">W.O. Number:</label>-->
                                <!--    <input id="woNum" name="woNum"/> <br>-->
                                <input type="submit" onclick='addingSampleReport()' value="Submit" name="updateForm">
                                <button id="cancelbtn" type="button"  onclick="document.getElementById('updateRec').style.display='none'" class="cancelbtn">Cancel</button>
                            </form>
                    </div>
                    
                    <div id="buttonOptions"><center>
                        <button class="homeNavBtn" onclick="window.location.href='samplingRequests.php'">Complete a Sampling Order</button><br>
                        <button class="homeNavBtn" onclick="window.location.href='collectedSamples.php'">Complete a Sampling Report</button><br>
                        <button class="homeNavBtn" onclick="window.location.href='sampleReports.php'">See Completed Orders</button><br>
                        <button class="homeNavBtn" onclick="window.location.href='admin.php'">Admin Edits</button><br>
                    </center></div>
                    
                </div>
                
                <div id="footer2" class="footer"><center>POWERD BY HARVEST CUBE</center></div>
            </div>
            
        </div>
    </body>
    
<!--LIBRARY SCRIPTS-->
    <script src="js/moment.js"></script>
    <script src="js/printThis.js"></script>
    <script src="js/jspdf.min.js"></script>

    <script>

                
    </script>
</html>