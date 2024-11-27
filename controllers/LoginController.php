<?php
session_start();

require_once __DIR__ . '/../models/LoginModel.php';
require_once __DIR__ . '/../config/Database.php';

class LoginController {

    private $loginModel;
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->loginModel = new LoginModel($this->db->getConnection());
    }

    public function login($usuario, $senha) {
            $usuario = $_POST["user"];
            $senha = $_POST["senha"];
            $lembrar = isset($_POST["lembrar"]) ? $_POST["lembrar"] : null;
            $criptsenha = md5($senha);
            
            if (isset($_COOKIE['usrLogado']) && isset($_COOKIE['senhaUsrLogado'])) {
                $usuario = $_COOKIE['usrLogado'];
                $senha = $_COOKIE['senhaUsrLogado'];
                $criptsenha = md5($senha);
            }

            $result = $this->loginModel->login($usuario, $criptsenha);

            if ($result) {
                $_SESSION["usuario"] = $usuario;
                $_SESSION["senha"] = $senha;
                $_SESSION['idUsuario'] = $result['id'];
                $_SESSION["tipoUsr"] = $result['tipo_usr'];

                if ($lembrar == "on") {
                    setcookie("usrLogado", $usuario, time() + (86400), "/");
                    setcookie("senhaUsrLogado", $senha, time() + (86400), "/");
                }

                return true;
            } else {
                session_destroy();
            }
    }

    public function logout() {
        if (isset($_SESSION["usuario"])) {
            session_unset();
            session_destroy();
            header("Location: ../index.php?acao=login");
            exit();
        }
    }
    

    public function processarAcoes() {
        if(isset($_POST['acao'])) {
            if($_POST['acao'] == 'logout') {
                $this->logout();
            } 
        }    
    }
}

$controllerLogin = new LoginController();
$controllerLogin->processarAcoes();
?>
