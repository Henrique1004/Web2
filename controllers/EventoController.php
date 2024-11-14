<?php
require_once 'models/Usuario.php';
class EventoController {
  private $model;

  public function __construct() {
      $this->model = new Usuario(1, 'João', 'joao@example.com');
  }

  public function index() {
      $usuario = $this->model;
      return $usuario;
  }

  public function salvar() {
      // Implemente a lógica de salvamento aqui
      echo "Usuário salvo com sucesso!";
  }
}

?>