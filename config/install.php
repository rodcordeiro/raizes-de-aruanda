<?php include_once '../db/db.class.php';
try 
{
  $dbclass = new DBClass(); 
  $connection = $dbclass->getConnection();
  $connection->exec('DROP TABLE icnt_users;');
  $connection->exec('DROP TABLE icnt_linha;');
  $connection->exec('DROP TABLE icnt_pontos;');
  echo "Droped old table structure\n";
  $sql = file_get_contents("database/update.sql"); 
  $connection->exec($sql);
  echo "Database and tables created successfully!";
}
catch(PDOException $e)
{
    echo $e->getMessage();
}
?>


