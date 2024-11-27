<?php
    session_start();

    if (!isset($_SESSION["usuario"]) || $_SESSION['tipoUsr'] != 'adm') {
        header("Location: index.php?acao=login");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Evento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            font-family: Arial, Helvetica, sans-serif;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Criar Evento</h1>
    <form>
        <label for="nome">Nome do Evento:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>

        <label for="data">Data do Evento:</label>
        <input type="date" id="data" name="data" required>

        <label for="local">Local do Evento:</label>
        <input type="text" id="local" name="local" required>

        <label for="max_participantes">Máximo de Participantes:</label>
        <input type="number" id="max_participantes" name="max_participantes" min="1" required>

        <button onclick="if(confirm('Deseja criar o evento?')) criarEvento()">Criar</button>  
    </form>
</div>

</body>
</html>

<script>
function criarEvento() {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "controllers/EventoController.php", true); 
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status == 200) {
            alert("Evento criado com sucesso!");
            window.location.href = "index.php?acao=eventoList"; 
        } else {
            alert("Erro ao criar evento.");
        }
    };

    const nome = document.getElementById('nome').value;
    const descricao = document.getElementById('descricao').value;
    const data = document.getElementById('data').value;
    const local = document.getElementById('local').value;
    const maxParticipantes = document.getElementById('max_participantes').value;

    xhr.send("acao=criarEvento&nome=" + nome + "&descricao=" + descricao + "&data=" + data + "&local=" + local + 
        "&max_participantes=" + maxParticipantes);  
}
</script>
