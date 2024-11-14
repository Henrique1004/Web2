<?php
class Usuario {
    private $conn;
    private $table_nome = "users";

    public $id;
    public $nome;
    public $email;
    public $senha;
    public $tipo_usr;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_nome . " SET nome=:nome, email=:email, senha=:senha, tipo_usr=:tipo_usr";
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->senha = htmlspecialchars(strip_tags($this->senha));
        $this->tipo_usr = htmlspecialchars(strip_tags($this->tipo_usr));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":senha", $this->senha);
        $stmt->bindParam(":tipo_usr", $this->tipo_usr);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readOne($email, $senha) {
        $query = "SELECT tipo_usr FROM " . $this->table_nome . " WHERE email=? AND senha=?";
        $stmt = $this->conn->prepare($query);
        $senha_md5 = md5($senha);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $senha_md5);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['tipo_usr'];
        }

    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_nome . " WHERE email=? AND senha=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->email);
        $stmt->bindParam(2, $this->senha);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
