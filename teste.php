<?php
date_default_timezone_set('America/Sao_Paulo');

$mysqli = new mysqli(getenv("CONN_URI"), getenv("ICNT_MYSQL_USER"), getenv("ICNT_MYSQL_PASSWORD"), getenv("ICNT_MYSQL_DATABASE"));

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
// Perform query
if ($result = $mysqli -> query("select linha from linha where categoria like 'orixa' order by linha asc;")) {
  echo "Returned rows are: " . $result -> num_rows;
  // Free result set
  $result -> free_result();
} else {
    echo $result->;
}

$mysqli -> close();


?>