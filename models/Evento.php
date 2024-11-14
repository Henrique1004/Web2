<?php
class Evento {
    private $conn;
    private $table_nome = "eventos";

    public $id;
    public $nome;
    public $descricao;
    public $data;
    public $local;
    public $participantes;
    public $max_participantes;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_nome . " SET nome=:nome, descricao=:descricao, data=:data, local=:local, participantes=:participantes, max_participantes=:max_participantes";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        $this->data = htmlspecialchars(strip_tags($this->data));
        $this->local = htmlspecialchars(strip_tags($this->local));
        $this->participantes = htmlspecialchars(strip_tags($this->participantes));
        $this->max_participantes = htmlspecialchars(strip_tags($this->max_participantes));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":data", $this->data);
        $stmt->bindParam(":local", $this->local);
        $stmt->bindParam(":participantes", $this->participantes);
        $stmt->bindParam(":max_participantes", $this->max_participantes);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_nome . " ORDER BY data";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT id, nome, descricao, data FROM " . $this->table_nome . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->nome = $row['nome'];
            $this->descricao = $row['descricao'];
            $this->data = $row['data'];
            $this->local = $row['local'];
        }
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_nome . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
