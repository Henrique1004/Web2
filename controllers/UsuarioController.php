<?php

require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/Database.php';

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

  public function criarUsuario($nome, $email, $senha) {
      $this->model->criarUsuario($nome, $email, $senha);
  }

  public function getUsr($email, $senha) {
    return $this->model->getUsr($email, $senha);
  }

  public function verificarPermissao($usr) {
    return $this->model->readOne($email, $senha);
  }

  public function processarAcoes() {
    if(isset($_POST['acao'])) {
        if($_POST['acao'] == 'cadastrar' && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['nome'])) {
            $this->criarUsuario($_POST['nome'], $_POST['email'], $_POST['senha']);
        }
    }    
  }
}

$controllerUsuario = new UsuarioController();
$controllerUsuario->processarAcoes();