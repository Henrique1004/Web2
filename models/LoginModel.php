<?php
class LoginModel {

    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function authenticate($usuario, $criptsenha) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE usr = ? AND senha = ?");
        $stmt->bind_param("ss", $usuario, $criptsenha);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>

