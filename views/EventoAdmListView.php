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
    <title>Eventos - Admin</title>
    <link rel="stylesheet" href="/views/style.css">
</head>
<body>
    <header>
        <h1>Painel do Administrador - Eventos</h1>
        <button onclick="logout()">Logout</button>
        <button onclick="location.href='index.php?acao=criarEventoView'">Criar Novo Evento</button>
    </header>

    <main>
        <section id="lista-eventos">
            <?php foreach ($eventos as $evento): ?>
                <div class="evento">
                    <h2><?php echo htmlspecialchars($evento['nome']); ?></h2>
                    <p>Descrição: <?php echo htmlspecialchars($evento['descricao']); ?></p>
                    <p>Data: <?php echo htmlspecialchars($evento['data']); ?></p>
                    <p>Local: <?php echo htmlspecialchars($evento['local']); ?></p>
                    <p>Inscritos: <?php echo htmlspecialchars($evento['participantes']); ?> / <?php echo htmlspecialchars($evento['max_participantes']); ?></p>
                    
                    <div class="acoes">
                        <button onclick="location.href='index.php?acao=editarEvento&id=<?php echo $evento['id']; ?>'">Editar</button>
                        <button onclick="if(confirm('Deseja excluir este evento?')) excluirEvento()">Excluir</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>

<script>
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

function excluirEvento() {
    event.preventDefault();

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/EventoController.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status == 200) {
            alert("Evento excluido com sucesso!");
        } else {
            alert("Erro ao excluir evento.");
        }
    };

    xhr.send(
        "acao=excluirEvento" +
        "&id=" + encodeURIComponent(<?php echo json_encode($evento['id']); ?>)
    );
}
</script>
