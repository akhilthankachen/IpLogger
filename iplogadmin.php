<?php
  $ini = parse_ini_file('config.ini');

  $dbhost = $ini['db_host'];
  $dbuser = $ini['db_user'];
  $dbpass = $ini['db_password'];
  $dbname = $ini['db_name'];
  $verbose = $ini['verbose'];

  function createDb($dbname,$conn){
    $sql = 'CREATE Database '.$dbname;
    $retval = mysql_query( $sql, $conn );
    return $retval;
  }

  function createTable($conn){
    $sql = 'CREATE TABLE admin( '.
          'username VARCHAR(10) NOT NULL, '.
          'password VARCHAR(10) NOT NULL )';

    $retval = mysql_query( $sql, $conn );
    return $retval;
  }

  function selectTable($conn){
    $sql = 'SELECT * FROM admin';
    $retval = mysql_query($sql,$conn);

    return $retval;
  }
?>

<html>
<head>
</head>
<body>
  <?php
     $conn = mysql_connect($dbhost, $dbuser, $dbpass);
     if($conn){
       mysql_select_db($dbname);
       $retval = selectTable($tbname,$conn);
       if($retval){
         echo '<h1>DATABASE EXISTS</h1> <a href = "login.php">Click here to login</a>';
       }
       else{
         echo "<h1>No table exist :".mysql_error()."</h1>";
         $retval = createDb($dbname,$conn);
         if(!retval){
           echo "couldnt create database";
         }
         $retval = createTable($conn);
         if(!retval){
           echo "couldnt create table";
         }
         $retval = selectTable($conn);
         if($retval){
           echo '<h1>DATABASE EXISTS</h1> <a href = "login.php">Click here to login</a>';
         }
         else{
           echo "no hope";
         }
       }
     }
     else{
       echo "<h1>Database connection error".mysql_error();
     }
  ?>

</body>
</html>
