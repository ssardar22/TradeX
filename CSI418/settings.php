<?php
session_start();
$_SESSION['timestamp'] = time();
$_SESSION['inactive'] = false;

//checks to see if the user is actually logged in
if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true){
    header('location: index.php');
    exit;
}

if(isset($_GET['uname'])){    
    $uname = $_GET['uname'];
    $_SESSION['uname'] = $uname;
}  
try {
    $connection = new PDO($dsn, $username, $password, $options);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $getPortfolioId = $connection->prepare("SELECT portfolio_id FROM portfolios WHERE portfolios.user_id =:user_id");
    
    
    $sql = "INSERT INTO stocks (ticker,portfolio_id) VALUES (:ticker,:currentPortId)";
    $stmt = $connection->prepare($sql);
    
    $data2 = [
    'ticker' => $tickerToAdd,
    'currentPortId' => $_SESSION['currentPortId'],
];
    
    $stmt->execute($data2);
    header("Location: ".$_SESSION['graphCameFrom']);
    exit;
}
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

?>   

<!DOCTYPE html>
<html>
<head>
<title>Trade X</title>
  <!--Bootstrap v4 -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 50%;
}

input[type=submit] {
  background-color: lightblue;
  color: #fff;
  cursor: pointer;
}
      
    </style>
    <script>
    window.onload = function() {
  inactivityTime(); 
}
    
    </script>    

</head>
<body>
    
    
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark" >
  <a class="navbar-brand" href="#">Trade X - <?php echo $_SESSION['uname'] ?></a>
   <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
   <!--End ofn Toggler/collapsibe Button -->  
    
    <!-- Navbar links -->
    <ul class="navbar-nav">
      <!-- landing Page link -->
      <li class="nav-item">
        <a class="nav-link" href="user.php">Portfolios</a>
      </li>
      <!-- User Manual link -->
      <li class="nav-item">
        <a class="nav-link" href="UserManual.php">User Manual</a>
      </li>
      <!-- Settings link-->
      <li class="nav-item">
        <a class="nav-link" href="#">Settings</a>
      </li>
      <!--Sign-out link-->  
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Sign-out</a>
      </li>
    </ul>
    <!--End of Navbar links -->
  </div>  
</nav>
    <!-- https://phppot.com/php/php-change-password-script/ -->
    
        <!--Content Div's-->
   <br>
   <div class="container"><h4>Account Settings</h4></div>
   <div class="container">
       <!--The Change Password contents --> 
       <!-- https://phppot.com/php/php-change-password-script/ -->
       <br>
         <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#changepass" aria-expanded="false" aria-controls="changePassword">
    Click here to change your password
  </button>
       <div class="collapse" id="changepass">
       <div class="changePassword">
<form name="createNewPassword" method="post" onSubmit="return validatePassword()">
<div style="width:500px;">
<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tblSaveForm">
<tr>
<td width="40%"><label>Current Password</label></td>
<td width="60%"><input type="password" name="currentPassword" class="txtField"/><span id="currentPassword"  class="required"></span></td>
</tr>
<tr>
<td><label>New Password</label></td>
<td><input type="password" name="newPassword" class="txtField"/><span id="newPassword" class="required"></span></td>
</tr>
<td><label>Confirm Password</label></td>
<td><input type="password" name="confirmPassword" class="txtField"/><span id="confirmPassword" class="required"></span></td>
<tr>
<td colspan="2"><input type="submit" name="submit" value="Submit" class="btnSubmit"></td>
</tr>
</table>
</div>
</form>

    </div>
    </div>
       <!--End of Change Password Contents -->
  </div>



    
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
        time = setTimeout(logout, 30000)
        // 1000 milliseconds = 1 second, so 900000 is 15 minutes
        //settings page will have 30000 for the demo (loggout after 30secs)
    }
};
   </script> 
    