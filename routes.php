<?php
require_once 'controllers/UsuarioController.php';
require_once 'controllers/EventoController.php';
require_once 'controllers/LoginController.php';
$controllerUsuario = new UsuarioController();
$controllerEvento = new EventoController();
$controllerLogin = new LoginController();

if (isset($_GET['acao'])) {
    switch ($_GET['acao']) {
        case 'login':
            include 'views/LoginView.php';
            break;
        case 'eventoList':
            $permissao = $controllerUsuario->validarUsr($_POST['user'], $_POST['senha']);
            if($permissao == 'adm') {
                include 'views/EventoAdmListView.php';
                break;
            } elseif($permissao == 'usr') {
                include 'views/EventoUsrListView.php';
                break;
            } else {
                include 'views/LoginView.php';
                echo 'Verifique o e-mail e a senha';
            }
            break;
        case 'salvar':
            $controller->salvar();
            break;
        default:
            echo "Ação não encontrada";
            break;
    }
} else {
   // include 'views/index.php';
   echo "Sem ação selecionada";
}
?>