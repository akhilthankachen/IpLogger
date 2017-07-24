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
         'current_url  TEXT NOT NULL, '.
         'reffered_url   TEXT NOT NULL, '.
         'date_time    timestamp(6) NOT NULL, '.
         'primary key ( id ))';

    $retval = mysql_query( $sql, $conn );

    if(! $retval ) {
      echo 'Could not create table: ' . mysql_error() . "\n";
    }

    mysql_close($conn);
?>
