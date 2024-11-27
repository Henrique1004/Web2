<?php
class Usuario {
    private $conn;
    private $table_nome = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criarUsuario($nome, $email, $senha) {
        $tipo_usr = "usr";
        $query = "INSERT INTO " . $this->table_nome . " (nome, email, senha, tipo_usr) VALUES (:nome, :email, :senha, :tipo_usr)";
        $stmt = $this->conn->prepare($query);
        $criptSenha = md5($senha);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":senha", $criptSenha);
        $stmt->bindParam(":tipo_usr", $tipo_usr);
        $stmt->execute();
    }

    public function getUsr($email, $senha) {
        $query = "SELECT * FROM " . $this->table_nome . " WHERE email=? AND senha=?";
        $stmt = $this->conn->prepare($query);
        $senha_md5 = md5($senha);
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $senha_md5);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
