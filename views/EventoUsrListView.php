<?php
    session_start();

    if (!isset($_SESSION["usuario"])) {
        header("Location: index.php?acao=login");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Eventos - Usuário</title>
    <link rel="stylesheet" href="/views/style.css">
</head>
<body>
    <header>
        <h1>Eventos Disponíveis</h1>
        <button onclick="logout()">Logout</button>
    </header>

    <main>
        <section id="lista-eventos">
            <?php foreach ($eventos as $evento): ?>
            <div class="evento">
                <h2><?php echo htmlspecialchars($evento['nome']); ?></h2>
                <p>Descrição: <?php echo htmlspecialchars($evento['descricao']); ?></p>
                <p>Data: <?php echo htmlspecialchars($evento['data']); ?></p>
                <p>Local: <?php echo htmlspecialchars($evento['local']); ?></p>

                <div class="acoes">
                    <button id="btnInscrever<?php echo $evento['id']; ?>" 
                        onclick="if(confirm('Deseja inscrever-se?')) inscreverUsuario(<?php echo $evento['id']; ?>, <?php echo $_SESSION['idUsuario']; ?>)">
                        Inscrever-se
                    </button>
                    <button id="btnCancInscricao<?php echo $evento['id']; ?>" 
                    onclick="if(confirm('Cancelar inscrição?')) cancelarInscricao(<?php echo $evento['id']; ?>, <?php echo $_SESSION['idUsuario']?>)">Cancelar Inscrição
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>

<script>
window.onload = function() {
    var eventos = <?php echo json_encode($eventos); ?>; 

    eventos.forEach(function(evento) {
        verificarInscricao(evento.id);
    });
};

function logout() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/LoginController.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status == 200) {
            window.location.href = "index.php?acao=login";
        }
    };

    xhr.send("acao=logout");
}

function inscreverUsuario(idEvento, idUsuario) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/EventoController.php", true); 
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status == 200) {
            alert("Inscrição realizada com sucesso!");
        } else {
            alert("Erro ao inscrever.");
        }
    };

    xhr.send("acao=inscrever&idEvento=" + idEvento + "&idUsuario=" + idUsuario); 
}

function cancelarInscricao(idEvento, idUsuario) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/EventoController.php", true);  
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status == 200) {
            alert("Cancelamento realizado com sucesso!");
        } else {
            alert("Erro ao cancelar.");
        }
    };

    xhr.send("acao=cancelar&idEvento=" + idEvento + "&idUsuario=" + idUsuario);  

}

function verificarInscricao(idEvento) {
    var idUsuario = <?php echo $_SESSION['idUsuario']; ?>;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/EventoController.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status == 200) {
            var resposta = xhr.responseText;

            var btnInscrever = document.getElementById("btnInscrever" + idEvento);
            var btnCancInscricao = document.getElementById("btnCancInscricao" + idEvento);

            if (resposta == "inscrito") {
                btnInscrever.style.display = "none"; 
                btnCancInscricao.style.display = "inline";
            } else {
                btnInscrever.style.display = "inline"; 
                btnCancInscricao.style.display = "none";  
            }
        }
    };

    xhr.send("acao=verificarInscricao&idEvento=" + idEvento + "&idUsuario=" + idUsuario);
}
</script>




