<!--
CSI 418
Modified from my CS410 - Intro to Databases Final Project
    
    This script creates the user landing page. The landing page
    contains links to all of the user functions, listed below. 
<img src="plus.png" height="240" width="320">
<?php include "templates/header.php"; ?>

-- takes user to page to add a portfolio -- 
    Create a new portfolio here!
    <a href="addPortfolio.php"><img src="plus.png"></a>


<?php include "templates/footer.php"; ?>
    -->
<?php
session_start();
$_SESSION['timestamp'] = time();
$_SESSION['inactive'] = false;

//checks to see if the user is actually logged in
if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true){
    header('location: index.php');
    exit;
}
/*
if(isset($_GET['uname'])){    
    $uname = $_GET['uname'];
        session_start();
    $_SESSION['uname'] = $uname;
}  
*/
else{
   // session_start();
   
    $uname = $_SESSION['uname'] ;
}


?>    
<!DOCTYPE html>
<html>
<head>
    <title>User Landing Page</title>
    
<script>
    window.onload = function() {
  inactivityTime(); 
}
    </script>    
    
<meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
.panel-default:hover {
    width:15%;
    opacity:0.8;
}
.panel-default:hover img{
	opacity: 0.6;
}

body{
    background: linear-gradient(to right top,#443C2C,#678C9C) fixed;
}

.dropbtn {
  background-color: linear-gradient(to left top,azure, blue);
  color: darkslategray;
  padding: 16px;
  font-size: 16px;
  border: linear-gradient(to left top,azure, grey);
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: azure;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: darkgreen;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}
        
        .portfolios{
              margin: 20px;
  border: 4px solid lightgray;
            text-align: center;
        }

.dropdown-content a:hover {background-color: greenyellow;}

.dropdown:hover .dropdown-content {
    display: block;   
        }

.dropdown:hover .dropbtn {background-color: dimgrey;}
</style>

</head>
<body>

<!--https://stackoverflow.com/questions/11651366/php-pass-data-to-html-form  -->
    
    
<div class="dropdown">
  <button class="dropbtn">My Profile - <?php echo $uname ?></button>
  <div class="dropdown-content">
    <a href="#">Account Settings (TBD)</a>
    <a href="#">Support (TBD)</a>
    <a href="user.php">Portfolios </a>  
    <a href="logout.php">Log Out</a>
   
      
  </div>
</div>



    <div class="container">
        <h1></h1>
    
    <div class="panel panel-default">
        <div class="panel-body"><a href="highcharts/index.php"><img src="plusText.png" alt="add portfolio image" /></a></div>
    </div>
    </div>
<!--
        <div class="portfolios">
        <h1>Portfolios show up here:</h1>
            <h2>Portfolio 1</h2>
            <h2>Portfolio 2</h2>
    
    </div>
-->
    <script>
    //  https://stackoverflow.com/questions/667555/how-to-detect-idle-time-in-javascript-elegantly?page=1&tab=votes#tab-top
    var inactivityTime = function () {
    var time;
    window.onload = resetTimer;
    // DOM Events
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
    document.onmousedown = resetTimer; // touchscreen presses
    document.ontouchstart = resetTimer;
    document.onclick = resetTimer;     // touchpad clicks
    document.onkeypress = resetTimer;

        //this is a separate logout page for users who are automatically logged out
    function logout() {
        location.href = 'inactiveLogout.php';
        
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, 900000)
        // 1000 milliseconds = 1 second, so 900000 is 15 minutes
    }
};
   </script> 
    
</body>
</html>