<?php
require_once 'models/Usuario.php';
class UsuarioController {
  private $model;
  private $db;

  public function __construct() {
    $this->db = new Database();
      $this->model = new Usuario($this->db->getConnection());
  }

  public function index() {
      $usuario = $this->model;
      return $usuario;
  }

  public function salvar() {
      // Implemente a lógica de salvamento aqui
      echo "Usuário salvo com sucesso!";
  }

  public function validarUsr($email, $senha) {
    return $this->model->readOne($email, $senha);
  }
}

?>