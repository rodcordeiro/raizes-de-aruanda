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
        $query = "SELECT
                IP.id,
                IP.ponto,
                IP.tipo,
                IP.audio_link,
                IP.title,
                IR.ritmo
            FROM
                `icnt_pontos` IP
            JOIN `icnt_linha` IL ON
                IP.linha = IL.id
            JOIN `icnt_ritmos` IR ON
                IR.id = IP.ritmo
            ORDER BY
                IP.ritmo ASC;";
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
        $query = "SELECT
                IP.id,
                IP.ponto,
                IP.tipo,
                IP.audio_link,
                IP.title,
                IR.ritmo
            FROM
                `icnt_pontos` IP
            JOIN `icnt_linha` IL ON
                IP.linha = IL.id
            JOIN `icnt_ritmos` IR ON
                IR.id = IP.ritmo
            WHERE
                IL.linha LIKE '".$linha."'
            ORDER BY
                IR.ritmo ASC;";
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
    public function listRythms(){
        $query = "SELECT
            IR.id,
            IR.ritmo
        FROM
            `icnt_ritmos` IR 
        ORDER BY
            IR.id ASC;";

        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        
        $ritmos = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
          extract($row);
          $p = array(
            "id"=>$id,
            "ritmo"=>$ritmo
          );
          array_push($ritmos,$p);
        }
        return $ritmos;   
    }
    public function saveRythm(){
        $query = "INSERT INTO `icnt_ritmos`(ritmo) VALUES ('". $this->ritmo ."');";
        $stmt = $this->connection->prepare($query);
        try{
            $stmt->execute();
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }
        return $stmt;
    }
}
?>