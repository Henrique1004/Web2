<?php
class Evento {
    
    private $conn;
    private $table_nome = "eventos";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function criarEvento($nome, $descricao, $data, $local, $max_participantes) {
        $query = "INSERT INTO " . $this->table_nome . 
        "(nome, descricao, data, local, max_participantes) 
        VALUES (:nome, :descricao, :data, :local, :max_participantes)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":data", $data);
        $stmt->bindParam(":local", $local);
        $stmt->bindParam(":max_participantes", $max_participantes);
        $stmt->execute();
    }

    public function editarEvento($id, $nome, $descricao, $data, $local, $max_participantes) {
        $query = "UPDATE " . $this->table_nome . " 
                  SET nome = :nome, 
                      descricao = :descricao, 
                      data = :data, 
                      local = :local, 
                      max_participantes = :max_participantes 
                  WHERE id = :id";
    
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":descricao", $descricao);
        $stmt->bindParam(":data", $data);
        $stmt->bindParam(":local", $local);
        $stmt->bindParam(":max_participantes", $max_participantes);
        $stmt->execute();
    }

    public function excluirEvento($id) {
        $query = "DELETE from " . $this->table_nome . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    public function getTodosEventos() {
        $query = "SELECT * FROM " . $this->table_nome . " ORDER BY data";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEvento($id) {
        $query = "SELECT * FROM " . $this->table_nome . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function inscrever($idEvento, $idUsuario) {
        $query = "SELECT participantes, max_participantes FROM eventos WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idEvento);
        $stmt->execute();
        $evento = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($evento) {
            if ($evento['participantes'] < $evento['max_participantes']) {
                $query = "UPDATE eventos SET participantes = participantes + 1 WHERE id = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $idEvento);
                $stmt->execute();
            } else {
                echo "Não há mais vagas para este evento.";
            }
        }

        $query = "INSERT INTO inscricoes (user_id, evento_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idUsuario);
        $stmt->bindParam(2, $idEvento);
        $stmt->execute();
    }

    public function cancelar($idEvento, $idUsuario) {
        $query = "DELETE FROM inscricoes WHERE evento_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idEvento);
        $stmt->bindParam(2, $idUsuario);
        $stmt->execute();
    }

    public function verificarInscricao($idEvento, $idUsuario) {
        $query = "SELECT id FROM inscricoes WHERE evento_id = ? AND user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $idEvento);
        $stmt->bindParam(2, $idUsuario);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC);

        if($id) {
            echo "inscrito";
        } else {
            echo "não inscrito";
        }
    }
    
}
?>
