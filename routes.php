<?php
session_start();

require_once 'controllers/UsuarioController.php';
require_once 'controllers/EventoController.php';
require_once 'controllers/LoginController.php';
$controllerUsuario = new UsuarioController();
$controllerEvento = new EventoController();
$controllerLogin = new LoginController();

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'cadastro':
            include 'views/CadastroView.html';
            break;
        case 'login':
            include 'views/LoginView.html';
            break;
        case 'eventoList':
            $loginOk = $controllerLogin->login($_POST['user'], $_POST['senha']);
            if($loginOk) {
                $controllerEvento->listarEventos($_SESSION['tipoUsr']);
            } else {
                include 'views/LoginView.html';
            }    
            break;
        case 'criarEventoView':
            include 'views/CriaEventoView.php';
            break;
        case 'editarEvento':
            include 'views/EventoEditView.php';
            break;
        default:
            echo "Ação não encontrada";
            break;
    }
} else {
   echo "Sem ação selecionada";
}
?>