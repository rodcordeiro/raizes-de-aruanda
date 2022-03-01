<?php
class Linhas{
    private $connection;
    private $table_name = 'icnt_linha';

    public $id;
    public $categoria;
    public $id_categoria;
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
        $query = "SELECT
        IL.id,
        IL.linha,
        CL.categoria,
        CL.id AS id_categoria
    FROM
        `icnt_linha` IL
    JOIN `icnt_categoria_linha` CL ON
        CL.id = IL.categoria
    ORDER BY
        IL.linha ASC;";
        $stmt = $this->connection->prepare($query);

        $stmt->execute();
        $count = $stmt->rowCount();
        
        $linhas = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          print_r($row);
          extract($row);

          $p = array(
            "id" => $id,
            "categoria" => $categoria,
            "id_categoria" => $id_categoria,
            "linha" => $linha
          );
          array_push($linhas,$p);
        }
        return $linhas;
    }
    
    public function filterByCategory($type){
        $query = "SELECT
        IL.id,
        IL.linha,
        CL.categoria,
        CL.id AS id_categoria
    FROM
        `icnt_linha` IL
    JOIN `icnt_categoria_linha` CL ON
        CL.id = IL.categoria
    WHERE
        CL.categoria LIKE '".$type."'
    ORDER BY
        IL.linha ASC;";
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

    public function getCategoriesIDs(){
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
    public function getCategories(){
        $query = "SELECT DISTINCT * FROM `icnt_categoria_linha`;";
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