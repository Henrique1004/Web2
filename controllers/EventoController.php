<?php

require_once __DIR__ . '/../models/Evento.php';
require_once __DIR__ . '/../config/Database.php';

class EventoController {
    private $model;
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->model = new Evento($this->db->getConnection());
    }

    public function listarEventos($permissao) {
        // Recupera os eventos
        $eventos = $this->model->getTodosEventos();

        if($permissao == "adm") {
            include 'views/EventoAdmListView.php';
        } else {
            include 'views/EventoUsrListView.php';
        }
    }

    public function listarEventosAjax() {
        $eventos = $this->model->getTodosEventos();

        // Retorna os eventos em formato JSON
        header('Content-Type: application/json');
        echo json_encode($eventos);
        exit();
    }

    public function criarEvento($nome, $descricao, $data, $local, $maxParticipantes) {
        $this->model->criarEvento($nome, $descricao, $data, $local, $maxParticipantes);
    }

    public function editarEvento($id, $nome, $descricao, $data, $local, $maxParticipantes) {
        $this->model->editarEvento($id, $nome, $descricao, $data, $local, $maxParticipantes);
    }

    public function excluirEvento($id) {
        $this->model->excluirEvento($id);
    }

    public function inscrever($idEvento, $idUsuario) {
        $this->model->inscrever($idEvento, $idUsuario);
    }

    public function cancelar($idEvento, $idUsuario) {
        $this->model->cancelar($idEvento, $idUsuario);
    }

    public function getEvento($id) {
        return $this->model->getEvento($id);
    }

    public function verificarInscricao($idEvento, $idUsuario) {
        $this->model->verificarInscricao($idEvento, $idUsuario);
    }

    public function processarAcoes() {
        if(isset($_POST['acao'])) {
            if($_POST['acao'] == 'inscrever' && isset($_POST['idEvento']) && isset($_POST['idUsuario'])) {
                $this->inscrever($_POST['idEvento'], $_POST['idUsuario']);
            }
            elseif($_POST['acao'] == 'cancelar' && isset($_POST['idEvento']) && isset($_POST['idUsuario'])) {
                $this->cancelar($_POST['idEvento'], $_POST['idUsuario']);
            }
            elseif($_POST['acao'] == 'criarEvento' && isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['data'])
                && isset($_POST['local']) && isset($_POST['max_participantes'])) {
                $this->criarEvento($_POST['nome'], $_POST['descricao'], $_POST['data'], $_POST['local'], $_POST['max_participantes']);
            } elseif($_POST['acao'] == 'editarEvento' && isset($_POST['id']) && isset($_POST['nome']) && isset($_POST['descricao']) && isset($_POST['data'])
                && isset($_POST['local']) && isset($_POST['max_participantes'])) {
                $this->editarEvento($_POST['id'], $_POST['nome'], $_POST['descricao'], $_POST['data'], $_POST['local'], $_POST['max_participantes']);
            } elseif($_POST['acao'] == 'excluirEvento' && isset($_POST['id'])) {
                $this->excluirEvento($_POST['id']);
            } elseif($_POST['acao'] == 'verificarInscricao' && isset($_POST['idEvento']) && isset($_POST['idUsuario'])) {
                $this->verificarInscricao($_POST['idEvento'], $_POST['idUsuario']);
            }
        }    
    }
}

$controllerEvento = new EventoController();
$controllerEvento->processarAcoes();
?>
