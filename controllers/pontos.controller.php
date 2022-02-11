<?php
class Pontos{
    private $connection;

    private $table_name = 'icnt_pontos';

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
        $query = "SELECT * FROM `" . $this->table_name . "` ORDER BY ritmo ASC;";
        $stmt = $this->connection->prepare($query);

        $stmt->execute();
        
        $pontos = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $p = array(
            "id"=>$id,
            "ritmo"=>$ritmo,
            "ponto"=>$ponto,
            "linha"=>$linha,
            "tipo"=>$tipo,
            "audio_link"=>$audio_link,
            "title"=>$title
          );
          array_push($pontos,$p);
        }
        return $pontos;
    }
    
    public function filter($linha){
        $query = "SELECT * FROM `" . $this->table_name . "` WHERE linha = '". $linha ."' ORDER BY ritmo ASC;";
        $stmt = $this->connection->prepare($query);

        
        $stmt->execute();
        
        $pontos = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $p = array(
            "id"=>$id,
            "ritmo"=>$ritmo,
            "ponto"=>$ponto,
            "linha"=>$linha,
            "tipo"=>$tipo,
            "audio_link"=>$audio_link,
            "title"=>$title
          );
          array_push($pontos,$p);
        }
        return $pontos;
    }
    
    //U
    public function update(){}
    //D
    public function delete(){}
}
?>