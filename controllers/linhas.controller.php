<?php
class Linhas{
    private $connection;
    private $table_name = 'icnt_linha';

    public $id;
    public $categoria;
    public $linha;
    

    public function __construct($connection){
        $this->connection = $connection;
    }

    
    public function create(){
        $query = "INSERT INTO `" . $this->table_name . "`(categoria, linha) VALUES ('". $this->categoria ."','".$this->linha."')";
        $stmt = $this->connection->prepare($query);
        try{
            $stmt->execute();
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }
        return $stmt;
    }
    public function list(){
        $query = "SELECT * FROM `" . $this->table_name . "` order by linha asc;";
        $stmt = $this->connection->prepare($query);

        $stmt->execute();
        $count = $stmt->rowCount();
        
        $linhas = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $p = array(
            "id" => $id,
            "categoria" => $categoria,
            "linha" => $linha
          );
          array_push($linhas,$p);
        }
        return $linhas;
    }
    
    public function filter($type){
        $query = "SELECT * FROM `" . $this->table_name . "` WHERE categoria = '". $type ."' order by linha asc;";
        $stmt = $this->connection->prepare($query);

        $stmt->execute();
        $count = $stmt->rowCount();
        
        $linhas = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
          $p = array(
            "id" => $id,
            "categoria" => $categoria,
            "linha" => $linha
          );
          array_push($linhas,$p);
        }
        return $linhas;
    }

    public function getCategories(){
        $query = "SELECT DISTINCT categoria FROM `" . $this->table_name . "`;";
        $stmt = $this->connection->prepare($query);

        $stmt->execute();
        $count = $stmt->rowCount();
        
        $linhas = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
          
            array_push($linhas,$categoria);
        }
        return $linhas;
    }
    
    //U
    public function update(){}
    //D
    public function delete(){}

}

?>