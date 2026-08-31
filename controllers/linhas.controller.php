<?php
class Linhas{
    private $connection;
    private $table_name = 'tb_linhas';

    public $id;
    public $categoria;
    public $id_categoria;
    public $linha;
    public $canal_youtube;
    public $saudacao;

    public function __construct($connection){
        $this->connection = $connection;
    }

    public function create(){
        $query = "INSERT INTO `{$this->table_name}` (categoria, nome) VALUES (:categoria, :nome)";
        $stmt = $this->connection->prepare($query);

        try{
            $stmt->execute([
                ':categoria' => $this->categoria,
                ':nome'      => $this->linha
            ]);
        }catch(PDOException $exception){
            echo "Error: " . $exception->getMessage();
        }
        return $stmt;
    }

    public function list(){
        $query = "SELECT
                IL.id,
                IL.nome as linha,
                CL.nome as categoria,
                CL.id AS id_categoria
            FROM `tb_linhas` IL
            JOIN `tb_categorias` CL ON CL.id = IL.categoria
            ORDER BY CL.id asc, IL.nome ASC
        ";

        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $linhas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $linhas[] = [
                "id" => $row["id"],
                "categoria" => $row["categoria"],
                "id_categoria" => $row["id_categoria"],
                "linha" => $row["linha"]
            ];
        }
        return $linhas;
    }

    public function findByName($linha){
        $query = "SELECT
                IL.id,
                IL.nome as linha,
                IL.canal_youtube,
                CL.nome as categoria,
                CL.id AS id_categoria
            FROM
                `tb_linhas` IL
            JOIN `tb_categorias` CL ON
                CL.id = IL.categoria
            WHERE
                IL.linha LIKE :linha
            LIMIT 1;";
        $stmt = $this->connection->prepare($query);

        try{
            $stmt->bindParam(':linha', $linha);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$row){
                return null;
            }
            return $row;
        }catch(PDOException $exception){
            return null;
        }
    }
    
    // (Recomendado) tornar o seu filterByCategory seguro também
    public function filterByCategory($type){
        $type = trim((string)$type);
        if ($type === '') return [];

        $query = "SELECT
                IL.id,
                IL.nome as linha,
                CL.nome as categoria,
                CL.id AS id_categoria
            FROM `tb_linhas` IL
            JOIN `tb_categorias` CL ON CL.id = IL.categoria
            WHERE CL.nome LIKE :type
            ORDER BY CL.id asc, IL.nome ASC
        ";

        $stmt = $this->connection->prepare($query);
        $stmt->execute([':type' => "%{$type}%"]);

        $linhas = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $linhas[] = [
                "id" => $row["id"],
                "categoria" => $row["categoria"],
                "id_categoria" => $row["id_categoria"],
                "linha" => $row["linha"]
            ];
        }
        return $linhas;
    }

    public function getCategoriesIDs(){
        $query = "SELECT DISTINCT categoria FROM `{$this->table_name}`;";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $cats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $cats[] = $row["categoria"];
        }
        return $cats;
    }

    public function getCategories(){
        $query = "SELECT DISTINCT a.id, a.nome as categoria
                  FROM tb_categorias a
                  ORDER BY a.id asc;";

        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        $cats = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $cats[] = $row["categoria"];
        }
        return $cats;
    }

    public function update(){}
    public function delete(){}
}
?>
