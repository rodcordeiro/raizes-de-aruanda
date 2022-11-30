<?php include_once '../db/db.class.php';
try 
{
  $dbclass = new DBClass(); 
  $connection = $dbclass->getConnection();
  $sql = file_get_contents("database/db.sql"); 
  $execution = $connection->exec($sql);
  echo "execution: {$execution}";
  print_r($execution);
  echo "<br/><br/>SQL script executed!";
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>


