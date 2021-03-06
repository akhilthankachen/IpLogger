<?php

   $ini = parse_ini_file('config.ini');

   $dbhost = $ini['db_host'];
   $dbuser = $ini['db_user'];
   $dbpass = $ini['db_password'];
   $dbname = $ini['db_name'];
   $verbose = $ini['verbose'];

   function ip_details($ip) {
       $json = file_get_contents("http://ipinfo.io/{$ip}/json");
       return $json;
   }

   function createDb($dbname,$conn){
     $sql = 'CREATE Database '.$dbname;
     $retval = mysql_query( $sql, $conn );
     return $retval;
   }

   function createTable($conn){
     $sql = 'CREATE TABLE log_table( '.
           'id INT NOT NULL AUTO_INCREMENT, '.
           'ip VARCHAR(45) NOT NULL, '.
           'hostname   TEXT , '.
           'org   TEXT , '.
           'city   TEXT , '.
           'region   TEXT , '.
           'country   TEXT , '.
           'api_json   TEXT , '.
           'xff_headers   TEXT , '.
           'current_url  TEXT , '.
           'reffered_url   TEXT , '.
           'date_time    timestamp(6) NOT NULL, '.
           'primary key ( id ))';

     $retval = mysql_query( $sql, $conn );
     return $retval;
   }

   function insertLog($conn){
     $ip_addr = $_SERVER['REMOTE_ADDR'];
     $request_url = $_SERVER['REQUEST_URI'];
     $refered_url = $_SERVER['HTTP_REFERER'];
     $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
     $details_json = ip_details($_SERVER['REMOTE_ADDR']);
     $details = json_decode($details_json);
     $xff = $_SERVER['HTTP_X_FORWARDED_FOR'];
     $xffjson = json_encode($xff);

     $sql = "INSERT INTO log_table ".
        "(ip, hostname, org, city, region, country, api_json, xff_headers, current_url, reffered_url) ".
        "VALUES ( '$ip_addr', '$hostname','$details->org','$details->city','$details->region','$details->country','$details_json','$xffjson','$request_url','$refered_url')";

        $retval = mysql_query( $sql, $conn );
        return $retval;
   }


   $conn = mysql_connect($dbhost, $dbuser, $dbpass);

   if( $conn ) {

     mysql_select_db($dbname);
     $retval = insertLog($conn);
     if(!$retval){

       if($verbose == true){
         echo "* Couldn't insert to table : ".mysql_error();
         echo "* Trying to create new database and table *";
       }
       createDb($dbname,$conn);
       createTable($conn);
       $retval_insert = insertLog($conn);
       if($retval_insert) {
         if($verbose == true){
           echo "* Inserted into table : success *";
         }
       }
       else {
         if($verbose == true){
           echo "* Inserted into table : failed *";
         }
       }

     }
     else {
       if($verbose == true){
         echo "* Inserted into table : success *";
       }
     }
   }
   else {

     if($verbose == true){
       echo "* Couldn't connect to database : ".mysql_error()." *";
     }
   }
    mysql_close($conn);
?>
