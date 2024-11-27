<?php

session_start();

class LoginModel {

    private $conn;
    private $table_nome = "users";
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($usuario, $senha) {
        $query = "SELECT * FROM " . $this->table_nome . " WHERE email=:email AND senha=:senha";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $usuario);
        $stmt->bindParam(":senha", $senha);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function logout() {
        if (isset($_SESSION["usuario"])) {
            session_unset();
            session_destroy();
        }
    }
}
?>

