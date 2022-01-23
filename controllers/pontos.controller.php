<?php
class Pontos{
    private $connection;
    private $table_name = 'pontos';

    // `id` int(10) NOT NULL AUTO_INCREMENT,
    // `ritmo` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
    // `ponto` mediumtext COLLATE utf8_unicode_ci,
    // `linha` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    // `tipo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    // `audio_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
    // `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  
    public $id;
    public $ritmo;
    public $ponto;
    public $linha;
    public $tipo;
    public $audio_link;
    public $title;


    

    public function __construct($connection){
        $this->connection = $connection;
    }

    //C
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
        $query = "SELECT * FROM `" . $this->table_name . "`;";
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
        $query = "SELECT * FROM `" . $this->table_name . "` WHERE categoria = '". $type ."';";
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
    
    //U
    public function update(){}
    //D
    public function delete(){}

}

?>