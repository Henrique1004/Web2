<?php
session_start();

require_once 'models/LoginModel.php';
require_once 'config/Database.php';

class LoginController {

    private $loginModel;
    private $db;

    public function __construct() {
        $this->db = new Database();
        $this->loginModel = new LoginModel($this->db->getConnection());
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["user"];
            $senha = $_POST["senha"];
            $lembrar = isset($_POST["lembrar"]) ? $_POST["lembrar"] : null;
            $criptsenha = md5($senha);
            
            if (isset($_COOKIE['usrLogado']) && isset($_COOKIE['senhaUsrLogado'])) {
                $usuario = $_COOKIE['usrLogado'];
                $senha = $_COOKIE['senhaUsrLogado'];
                $criptsenha = md5($senha);
            }

            $result = $this->loginModel->authenticate($usuario, $criptsenha);

            if ($result->num_rows > 0) {
                $_SESSION["usuario"] = $usuario;
                $_SESSION["senha"] = $senha;

                if ($lembrar == "on") {
                    setcookie("usrLogado", $usuario, time() + (86400), "/");
                    setcookie("senhaUsrLogado", $senha, time() + (86400), "/");
                }

                header("Location: index.html");
                exit();
            } else {
                echo "Usuário ou senha incorretos!";
                session_destroy();
            }
        }
    }
}
?>
