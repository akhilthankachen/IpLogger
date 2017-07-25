<?php

  $ini = parse_ini_file('config.ini');

  $dbhost = $ini['db_host'];
  $dbuser = $ini['db_user'];
  $dbpass = $ini['db_password'];
  $dbname = $ini['db_name'];
  $verbose = $ini['verbose'];


?>

<html>
<head>
  <style>
    
  </style>
</head>
<body>
  <div class="container">
    <header>
      <h1>IpLogger</h1>
      <p>IpLogger logs ip of the client, Hostname, current url, refered url and time </p>
      <h2>Logs : </h2>
    </header>
    <div class="content">
      <?php
      $conn = mysql_connect($dbhost, $dbuser, $dbpass);
      if(!$conn){
        echo "<h3>
                Connection to db error : " .mysql_error(). "
              </h3>";
      }
      else{
        $sql = 'SELECT id, ip, hostname, current_url, reffered_url, date_time FROM log_table';
        mysql_select_db($dbname);
        $retval = mysql_query( $sql, $conn );
        if(! $retval){
          echo "<h3>
                  Table not found : " .mysql_error(). "
                </h3>";
        }
        else{
          echo ' <table>
                <tr>
                <th>id</th>
                <th>ip</th>
                <th>hostname</th>
                <th>current_url</th>
                <th>refered_url</th>
                <th>date time</th>
                </tr> ';
          while($row = mysql_fetch_array($retval, MYSQL_ASSOC)) {
            echo "<tr><td>{$row['id']}</td> ".
                  "<td>{$row['ip']}</td> ".
                  "<td>{$row['hostname']}</td> ".
                  "<td>{$row['current_url']}</td>".
                  "<td>{$row['reffered_url']}</td>".
                  "<td>{$row['date_time']}</td></table>";
          }
        }
      }?>
    </div>
  </div>
</body>
</html>
