<?php
   $dbhost = 'localhost:3036';
   $dbuser = 'root';
   $dbpass = 'root';
   $dbname = 'IpLogger';
   $conn = mysql_connect($dbhost, $dbuser, $dbpass);

   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }

   $sql = 'CREATE Database '.$dbname;
   $retval = mysql_query( $sql, $conn );

   if(! $retval ) {
     echo 'Could not create database: ' . mysql_error() . "\n";
   }

   mysql_select_db($dbname);

   $sql = 'CREATE TABLE log_table( '.
         'id INT NOT NULL AUTO_INCREMENT, '.
         'ip VARCHAR(45) NOT NULL, '.
         'hostname   TEXT NOT NULL, '.
         'current_url  TEXT NOT NULL, '.
         'reffered_url   TEXT , '.
         'date_time    timestamp(6) NOT NULL, '.
         'primary key ( id ))';

    $retval = mysql_query( $sql, $conn );

    if(! $retval ) {
      echo 'Could not create table: ' . mysql_error() . "\n";
    }
    $ip_addr = $_SERVER['REMOTE_ADDR'];
    $request_url = $_SERVER['REQUEST_URI'];
    $refered_url = $_SERVER['HTTP_REFERER'];
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

    $sql = "INSERT INTO log_table ".
       "(ip, hostname, current_url, reffered_url) ".
       "VALUES ( '$ip_addr', '$hostname','$request_url','$refered_url')";

       $retval = mysql_query( $sql, $conn );

       if(! $retval ) {
          echo 'Could not enter data: ' . mysql_error();
       }

    mysql_close($conn);
?>
