<?php
session_start();
$_SESSION['timestamp'] = time();
$_SESSION['inactive'] = false;
$_SESSION['chosenTicker'] = '';
$_SESSION['period'] = 7;
$_SESSION['publicPortUser'] = '';

function phpAlert($msg) {
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}


//checks to see if the user is actually logged in
if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true){
    header('location: index.php');
    exit;
}

if(isset($_GET['uname'])){    
    $uname = $_GET['uname'];
    $_SESSION['uname'] = $uname;
}  

if(isset($_SESSION['portExists'])){
    if($_SESSION['portExists'] != ''){
        phpAlert($_SESSION['portExists']);
        $_SESSION['portExists'] = '';
    }

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
  <link rel="stylesheet" href="../templates/style.css">
  <link href="https://fonts.googleapis.com/css?family=Cinzel|Marck+Script|Philosopher&display=swap" rel="stylesheet">
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
  width: 70%;
}

input[type=submit] {
  background-color: blue;
  color: #fff;
  cursor: pointer;
}
        tr:hover {
            background-color: antiquewhite;
        }
        tr{
            background-color:#f5f5f5;
        }
      
    </style>
    <script>
    window.onload = function() {
  inactivityTime(); 
}
    
    </script>    

</head>
<body>
    
    
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" id="logo" href="homepage.php">Trade X - <?php echo $_SESSION['uname'] ?></a>
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
        <a class="nav-link" href="../user.php">Portfolios</a>
      </li>
      <!-- User Manual link -->
      <li class="nav-item">
        <a class="nav-link" href="../UserManual.php">User Manual</a>
      </li>
      <!-- Settings link-->
      <li class="nav-item">
        <a class="nav-link" href="../settings.php">Settings</a>
      </li>
      <!--Sign-out link-->  
      <li class="nav-item">
        <a class="nav-link" href="Helper Files/logout.php">Sign-out</a>
      </li>
    </ul>
    <!--End of Navbar links -->
  </div>  
</nav>

    <!--Content Div's-->
<br>
<br>
<div class="container">    
<div class="card-columns">
    <div class="card bg-info">
      <div class="card-body card-md text-left">
        <div class="container">
          <h3><strong>Choose a Portfolio to Compare to:</strong></h3>
          <a href="#NewPort" class="btn btn-dark" data-toggle="collapse">View Portfolio's</a>
          <div id="NewPort" class="collapse">
   
 
  <?php
    $_SESSION['portfolioToCompare'] ='';
    require "../Data Initialization/config.php";
    require "../Data Initialization/common.php";
    echo "<table style='border: 4px solid black;  border-radius: 100%;'>";
    echo "<h2><b>Your Portfolios</b><h2></tr>";

class TableRowsZ extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width: 150px;  border: 4px solid black; border:font-weight: bold; font-size:30px;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr style=' padding-top: 12px; padding-bottom: 12px; background-color: #4CAF50; color: white;'>";
    }

    function endChildren() {
        echo "</tr>" . "\n";
                echo '<td id="ec"> <form action="getComparisonPortfolio.php" method="post"><span><input type="submit" name= "'.$_SESSION['portfolioToCompare'].'"value="Open ' .$_SESSION['portfolioToCompare'].' in Portfolio Comparison"></span><input type ="hidden" name="'.$_SESSION['publicPortUser'].'"></form></td>  ';

    }
}

      
      
      class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:  150px; font-size:25px;'>" . parent::current(). "</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "</tr>" . "\n";

    }
}

      
      


try {
    $connection = new PDO($dsn, $username, $password, $options);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $portfolioNames = $connection->prepare("SELECT portfolio_name FROM portfolios WHERE portfolios.user_id =:user_id");
    $portfolioNames->execute(['user_id'=>$_SESSION["user_id"]]);

    // set the resulting array to associative
    $result = $portfolioNames->setFetchMode(PDO::FETCH_ASSOC);
    
        $getPortfolioId = $connection->prepare("SELECT portfolio_id FROM portfolios WHERE portfolios.user_id =:user_id");
        $getPortfolioId->execute(['user_id'=>$_SESSION["user_id"]]);
        //$portfolio_id = $getPortfolioId->setFetchMode(PDO::FETCH_ASSOC);
        $getPortfolioId = $getPortfolioId->fetchAll();
    
        
    $printPortfolioNames = $connection->prepare("SELECT portfolio_name FROM portfolios WHERE portfolios.user_id =:user_id");
    $printPortfolioNames->execute(['user_id'=>$_SESSION["user_id"]]);
    $printPortfolioNames = $printPortfolioNames->fetchAll();
    $counter = 0;
  // echo array_unique($getPortfolioId[$counter]);
    
    foreach(new TableRowsZ(new RecursiveArrayIterator($portfolioNames->fetchAll())) as $k=>$v) {
        echo $v;
       // $_SESSION['portfolioToCompare'] = ltrim($v, "<td style='width: 150px; border: 3px solid black; font-weight: bold; font-size:30px;'>");
       // $_SESSION['portfolioToCompare'] = str_replace("</td>","",$_SESSION['portfolioToCompare']);
         $_SESSION['portfolioToCompare'] = implode("",array_unique($printPortfolioNames[$counter]));
        
        $_SESSION['$currentId'] = implode("",array_unique($getPortfolioId[$counter]));
                        $counter = $counter + 1;
        $retrieveTickers = $connection->prepare("SELECT ticker FROM stocks WHERE portfolio_id=:pid");
        $retrieveTickers->execute(['pid'=>$_SESSION['$currentId']]);

        $result2 = $retrieveTickers->setFetchMode(PDO::FETCH_ASSOC);

            foreach(new TableRows(new RecursiveArrayIterator($retrieveTickers->fetchAll())) as $o=>$p) {
                echo $p;
            }
        
    }
 
  
    
    //same code but now for public portfolios
    echo "</table><br>";
    echo "<table style='border: 4px solid black;'>";
    echo "<h2><b>Public Portfolios</b> </tr>";
    
        $portfolioNames = $connection->prepare("SELECT portfolio_name FROM portfolios WHERE visibility = 1 AND portfolios.user_id <>:user_id");
    $portfolioNames->execute(['user_id'=>$_SESSION["user_id"]]);
        // set the resulting array to associative
    $result = $portfolioNames->setFetchMode(PDO::FETCH_ASSOC);
    
    
        $getPortfolioId = $connection->prepare("SELECT portfolio_id FROM portfolios WHERE visibility = 1 AND portfolios.user_id <>:user_id");
        $getPortfolioId->execute(['user_id'=>$_SESSION["user_id"]]);
        //$portfolio_id = $getPortfolioId->setFetchMode(PDO::FETCH_ASSOC);
        $getPortfolioId = $getPortfolioId->fetchAll();
    
    
    
    $printPortfolioNames = $connection->prepare("SELECT portfolio_name FROM portfolios WHERE visibility = 1 AND portfolios.user_id <>:user_id");
    $printPortfolioNames->execute(['user_id'=>$_SESSION["user_id"]]);
    $printPortfolioNames = $printPortfolioNames->fetchAll();
    $counter = 0;
        foreach(new TableRowsZ(new RecursiveArrayIterator($portfolioNames->fetchAll())) as $k=>$v) {
        echo $v;
       // $_SESSION['portfolioToCompare'] = ltrim($v, "<td style='width: 150px; border: 3px solid black; font-weight: bold; font-size:30px;'>");
       // $_SESSION['portfolioToCompare'] = str_replace("</td>","",$_SESSION['portfolioToCompare']);
         $_SESSION['portfolioToCompare'] = implode("",array_unique($printPortfolioNames[$counter]));
        
        $_SESSION['$currentId'] = $getPortfolioId[$counter][0];
        $counter = $counter + 1;
        $retrieveTickers = $connection->prepare("SELECT ticker FROM stocks WHERE portfolio_id=:pid");
        $retrieveTickers->execute(['pid'=>$_SESSION['$currentId']]);
            
            
                    $getUserId = $connection->prepare("SELECT user_id FROM portfolios WHERE portfolio_id=:pid");
        $getUserId->execute(['pid'=>$_SESSION['$currentId']]);
        //$portfolio_id = $getPortfolioId->setFetchMode(PDO::FETCH_ASSOC);
        $getUserId = $getUserId->fetch();
        $_SESSION['publicPortUser'] = $getUserId[0];
            
            

        $result2 = $retrieveTickers->setFetchMode(PDO::FETCH_ASSOC);

            foreach(new TableRows(new RecursiveArrayIterator($retrieveTickers->fetchAll())) as $o=>$p) {
                echo $p;
            }
        
    }
    
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
echo "</table>";

?>
 </div>
        </div> 
      </div>
    </div>
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
        location.href = '../Helper Files/inactiveLogout.php';
        
    }

    function resetTimer() {
        clearTimeout(time);
        time = setTimeout(logout, 900000)
        // 1000 milliseconds = 1 second, so 900000 is 15 minutes
    }
};
   </script>   

</div>
</body>
</html>
