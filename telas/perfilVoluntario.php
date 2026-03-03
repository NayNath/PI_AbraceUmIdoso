<?php
/*editar: foto, Sobre mim, celular/telefone, email, cep,estado, cidade, bairro, rua, numero*/
require '../conexao.php';

$sql = "SELECT * FROM usuarios";

// Executa o comando SQL diretamente, pois não há parâmetros
$stmt = $pdo->query($sql);

// Pega todos os resultados da consulta e transforma em um array (lista)
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Voluntário</title>
     <link rel="stylesheet" href="./../css/estilo.css">
    <link rel="stylesheet" href="./../css/">

</head>
<body>
        <head>
    <meta charset="UTF-8">
    <title>Seu Título</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
   
    <link rel="stylesheet" href="caminho/para/seu/style.css">
    </head>
    <header class="cabecalho">
        <a href="#" class="logo">
            <img src="./../imagem/logoPI.jpg" alt="LogoAbraceUmIdoso">
        </a>
        <nav class="nav-menu">
            <ul>
                <li><a href="./cadastro.html">Cadastrar</a></li>
                <li><a href="/login" class="ga-nav" title="agendamento">Login</a></li>
            </ul>
            <ul>
                <li><a href="./inicio.html">Início</a></li>
                <li><a href="/agendamento" class="ga-nav" title="agendamento">Agendamento</a></li>
                <li><a href="/cartas" class="ga-nav" title="cartas">Cartas</a></li>
                <li><a href="./contatos.html" class="ga-nav" title="contato">Fale Conosco</a></li>
            </ul>
        </nav>
    </header>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['fotoPerfil'] ?></td>
                <td><?= $u['nomePessoa'] ?></td>
                <td><?= $u['sobre'] ?></td>
                <td><?= $u['cep'] ?></td>
                <td><?= $u['estado'] ?></td>
                <td><?= $u['cidade'] ?></td>
                <td><?= $u['bairro'] ?></td>
                <td><?= $u['numero'] ?></td>
                <td><?= $u['rua'] ?></td>
                <td><?= $u['senha'] ?></td>

                <td><?= ucfirst($u['tipo']) ?></td>
                <td>
                    <a class="btn-editar" href="editar.php?id=<?= $u['idUsuario'] ?>">Editar</a>
                    <a class="btn-excluir" href="excluir.php?id=<?= $u['idUsuario'] ?>" onclick="return confirm('Deseja realmente excluir?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>





    <footer class="rodape"><p>© 2025 RastroCerto. Todos os direitos reservados</p></footer>
</body>
</html>
